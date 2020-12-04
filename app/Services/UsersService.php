<?php


namespace App\Services;


use App\Presenters\UsersPresenter;
use App\Repositories\UsersCheckRepository;
use App\Repositories\UsersRepository;
use App\Repositories\UsersModulesActionsRepository;
use App\Repositories\UsersModulesRepository;
use App\Services\Traits\CrudMethods;
use App\Util\Functions;
use Carbon\Carbon;

class UsersService extends AppService
{
    use CrudMethods;

    /**
     * @var UsersRepository
     */
    protected $repository;

    /**
     * @var UsersModulesRepository
     */
    protected $usersModulesRepository;

    protected $actionsRepository;

    protected $checkRepository;

    public function __construct(UsersRepository $repository,
                                UsersModulesRepository $usersModulesRepository,
                                UsersModulesActionsRepository $actionsRepository,
                                UsersCheckRepository $checkRepository)
    {
        $this->repository = $repository;
        $this->usersModulesRepository = $usersModulesRepository;
        $this->actionsRepository = $actionsRepository;
        $this->checkRepository = $checkRepository;
        $this->repository->setPresenter(UsersPresenter::class);
    }

    /**
     * @param $id
     * @param bool $skipPresenter
     * @return mixed
     */
    public function find($id, $skipPresenter = false)
    {
        $user = $this->repository
            ->with(['modules', 'checks'])
            ->find($id);

        $checks = $this->checkRepository->findWhere([
          'users_id' => $id,
          ['start', '>=', Carbon::now()->firstOfMonth()],
          ['start', '<', Carbon::now()->lastOfMonth()]
        ]);

        $hours = (Carbon::now()->diff(Carbon::now()))->format('%h:%i:%s');

        foreach ($checks as $check){
          $hours = Functions::sumDatetime($hours, Functions::subtractDateTime($check['end'], $check['start']));
        }

        $modules = $user['data']['modules']->toArray();
        foreach ($modules as $key => $module) {
            $user_module = $this->usersModulesRepository
                ->with('actions')
                ->findWhere(['user_id' => $user['data']['id'], 'module_id' => $module['id']])
                ->first()->toArray();
            $user['data']['modules'][$key]['user_module'] = $user_module;
        }
        return ['user' => $user, 'hours' => $hours, 'points' =>intdiv(strtotime($hours), 720000)];
    }

    public function updateUserModule($id)
    {
        $userModule = $this->usersModulesRepository->find($id);
        $userModule->auth = !$userModule->auth;
        $userModule->save();

        return $this->find($userModule->user_id);
    }

    public function updateUserModuleAction($actionId)
    {
        $action = $this->actionsRepository->find($actionId);
        $action->auth = !$action->auth;
        $action->save();

        return ['data' => $action->auth];
    }

    public function getUserIdByEmailAndRole(array $data)
    {
        if (isset($data['email']) && isset($data['client'])) {
            $where = $data['client'] ? ['email' => $data['email'], 'role' => 'client'] : ['email' => $data['email'], ['role', '!=', 'client']];
            $user = $this->repository->skipPresenter(true)
                ->findWhere($where, ['id', 'email', 'role'])
                ->first();

            return $this->returnSuccess($user);
        } else {
            return $this->returnError([], 'Dados inválidos para a busca');
        }
    }
}
