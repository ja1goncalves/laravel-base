<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UsersCheckRepository;
use App\Entities\UsersCheck;
use App\Validators\UsersCheckValidator;

/**
 * Class UsersCheckRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UsersCheckRepositoryEloquent extends BaseRepository implements UsersCheckRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UsersCheck::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UsersCheckValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
