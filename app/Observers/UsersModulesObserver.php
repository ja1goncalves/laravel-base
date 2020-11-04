<?php

namespace App\Observers;

use App\Entities\UsersModules;
use App\Repositories\UsersModulesActionsRepository;
use App\Util\ActionsEnum;

class UsersModulesObserver
{
    /**
     * @var UsersModulesActionsRepository
     */
    protected $actionsRepository;

    /**
     * UsersModulesObserver constructor.
     * @param UsersModulesActionsRepository $actions
     */
    public function __construct(UsersModulesActionsRepository $actions)
    {
        $this->actionsRepository = $actions;
    }

    public function created(UsersModules $usersModules)
    {
        $actions = ActionsEnum::getActions();
        foreach ($actions as $action) {
            $user_module_action = [
                'user_module_id' => $usersModules->getAttribute('id'),
                'action' => $action,
                'auth' => $action == 'index'
            ];
            $this->actionsRepository->create($user_module_action);
        }
    }
}
