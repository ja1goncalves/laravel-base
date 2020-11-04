<?php

namespace App\Http\Middleware;

use App\Repositories\ModulesRepository;
use App\Repositories\UsersRepository;
use App\Repositories\UsersModulesActionsRepository;
use App\Repositories\UsersModulesRepository;
use App\Util\Functions;
use App\Util\UserStatusEnum;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Acl
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user_logged;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string[]
     */
    private $allowed_route = ['passport', 'auth'];

    /**
     * @var ModulesRepository
     */
    protected $modulesRepository;

    /**
     * @var UsersModulesRepository
     */
    protected $usersModulesRepository;

    public function __construct(ModulesRepository $modulesRepository,
                                UsersModulesRepository $usersModulesRepository)
    {
        $this->modulesRepository = $modulesRepository;
        $this->usersModulesRepository = $usersModulesRepository;
        $this->user_logged = Auth::user();

        $this->isUnauthorized();
        $this->getModuleAndAction();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->checkPermissions()) {
            return response()->json([
                'error' => true,
                'message' => 'User is forbidden to continue access this route',
                'data' => false
            ], 403);
        }

        return $next($request);
    }

    private function getModuleAndAction()
    {
        $route_details = Functions::routeDetails(Route::current()->getName());
        $this->action = $route_details['action'];
        $this->module = $route_details['module'];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function isUnauthorized()
    {
        if (!is_null($this->user_logged)) {
            if (!is_null($this->user_logged) && !UserStatusEnum::acceptableStatus($this->user_logged->status)) {
                $this->user_logged->token()->revoke();
                return response()->json([
                    'error' => true,
                    'message' => 'User is not active to access',
                    'data' => false
                ], 403);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => 'User not logged',
                'data' => false
            ], 500);
        }
    }

    /**
     * @return bool
     */
    private function checkPermissions(): bool
    {
        if ($this->user_logged->role != 'admin') {
            if (in_array($this->module, $this->allowed_route)) {
                return true;
            }

        $module = $this->modulesRepository
            ->findByField('route', $this->module)
            ->first();

        if ($module) {
            $user_modules = $this->usersModulesRepository
                ->with(['actions' => function ($q){
                    return $q->where('action', '=', $this->action)->get(['id']);
                }])
                ->findWhere(['user_id' => $this->user_logged->id, 'module_id' => $module['id']], ['id', 'auth'])
                ->first();

                return $this->authUserModuleAction($user_modules->toArray());
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    private function authUserModuleAction(array $user_module)
    {
        return (!is_null($user_module) && $user_module['auth']) &&
            (!is_null($user_module['actions'][0]) && $user_module['actions'][0]['auth']);
    }
}
