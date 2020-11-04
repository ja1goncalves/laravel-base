<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UsersModulesRepository;
use App\Entities\UsersModules;
use App\Validators\UsersModulesValidator;

/**
 * Class UsersModulesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UsersModulesRepositoryEloquent extends BaseRepository implements UsersModulesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UsersModules::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
