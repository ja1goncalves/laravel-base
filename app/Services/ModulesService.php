<?php


namespace App\Services;


use App\Presenters\ModulesPresenter;
use App\Repositories\ModulesRepository;
use App\Services\Traits\CrudMethods;

class ModulesService extends AppService
{
    use CrudMethods;

    /**
     * @var ModulesRepository
     */
    protected $repository;

    public function __construct(ModulesRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->setPresenter(ModulesPresenter::class);
    }
}
