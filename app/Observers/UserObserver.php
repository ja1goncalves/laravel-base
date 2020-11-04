<?php

namespace App\Observers;

use App\Entities\Users;
use App\Repositories\ModulesRepository;
use App\Repositories\UsersModulesRepository;
use App\Util\UserRoleEnum;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * @var UsersModulesRepository
     */
    protected $usersModulesRepository;

    /**
     * @var ModulesRepository
     */
    protected $modulesRepository;

    /**
     * UserObserver constructor.
     * @param ModulesRepository $modulesRepository
     * @param UsersModulesRepository $usersModulesRepository
     */
    public function __construct(ModulesRepository $modulesRepository,
                                UsersModulesRepository $usersModulesRepository)
    {
        $this->usersModulesRepository = $usersModulesRepository;
        $this->modulesRepository = $modulesRepository;
    }

    public function saving(Users $user)
    {
        if (isset($user->password)) {
            $user->password = Hash::make($user->password);
        }
    }
    public function created(Users $user)
    {
        if ($user->getAttribute('role') != UserRoleEnum::CLIENT) {
            $modules = $this->modulesRepository->all('id');
            foreach ($modules as $module) {
                $user_module = [
                    'user_id' => $user->getAttribute('id'),
                    'module_id' => $module->id,
                ];
                $this->usersModulesRepository->create($user_module);
            }
        }
    }
}
