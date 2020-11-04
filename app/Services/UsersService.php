<?php


namespace App\Services;


use App\Presenters\UserPresenter;
use App\Repositories\UserRepository;
use App\Repositories\UsersModulesActionsRepository;
use App\Repositories\UsersModulesRepository;
use App\Services\Traits\CrudMethods;

class UsersService extends AppService
{
    use CrudMethods;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UsersModulesRepository
     */
    protected $usersModulesRepository;

    protected $actionsRepository;

    public function __construct(UserRepository $repository,
                                UsersModulesRepository $usersModulesRepository,
                                UsersModulesActionsRepository $actionsRepository)
    {
        $this->repository = $repository;
        $this->usersModulesRepository = $usersModulesRepository;
        $this->actionsRepository = $actionsRepository;
        $this->repository->setPresenter(UserPresenter::class);
    }

    /**
     * @param $id
     * @param bool $skipPresenter
     * @return mixed
     */
    public function find($id, $skipPresenter = false)
    {
        $user = $this->repository
            ->with('modules')
            ->find($id);

        $modules = $user['data']['modules']->toArray();
        foreach ($modules as $key => $module) {
            $user_module = $this->usersModulesRepository
                ->with('actions')
                ->findWhere(['user_id' => $user['data']['id'], 'module_id' => $module['id']])
                ->first()->toArray();
            $user['data']['modules'][$key]['user_module'] = $user_module;
        }
        return $user;
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
