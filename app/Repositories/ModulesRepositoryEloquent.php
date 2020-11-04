<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModulesRepository;
use App\Entities\Modules;
use App\Validators\ModulesValidator;

/**
 * Class ModulesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ModulesRepositoryEloquent extends BaseRepository implements ModulesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Modules::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ModulesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
