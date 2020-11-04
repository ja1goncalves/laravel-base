<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UsersModulesActionsRepository;
use App\Entities\UsersModulesActions;
use App\Validators\UsersModulesActionsValidator;

/**
 * Class UsersModulesActionsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UsersModulesActionsRepositoryEloquent extends BaseRepository implements UsersModulesActionsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UsersModulesActions::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
