<?php

namespace App\Services\Traits;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CrudMethods
 * @package app\Services\Traits
 */
trait CrudMethods
{
    /** @var  RepositoryInterface $repository */
    protected $repository;

    /**
     * @param int $limit
     * @return mixed
     */
    public function all($limit = 20)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return $this->repository->orderBy('created_at', 'desc')->all();
    }

    /**
     * @param array $data
     * @param bool $skipPresenter
     * @return mixed
     */
    public function create(array $data, $skipPresenter = false)
    {
        return $this->repository->skipPresenter($skipPresenter)->create($data);
    }

    /**
     * @param $id
     * @param bool $skipPresenter
     * @return mixed
     */
    public function find($id, $skipPresenter = false)
    {
        return $this->repository->skipPresenter($skipPresenter)->find($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return array|mixed
     */
    public function update(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param array $data
     * @param bool $first
     * @param bool $presenter
     * @param bool $count
     * @return mixed
     */
    public function findWhere(array $data, $first = false, $presenter = false, $count = false)
    {
        if ($first) {
            return $this->repository->skipPresenter()->findWhere($data)->first();
        }
        if ($presenter) {
            return $this->repository->findWhere($data)->first();
        }
        if ($count) {
            return $this->repository->skipPresenter()->findWhere($data)->count();
        }
        return $this->repository->skipPresenter()->findWhere($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $deleted = $this->repository->delete($id);
        return [
            'message' => 'Deleted',
            'error' => !$deleted
        ];
    }
}
