<?php


namespace App\Services;


use App\Presenters\UsersCheckPresenter;
use App\Repositories\UsersCheckRepository;
use App\Services\Traits\CrudMethods;
use App\Util\Functions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UsersCheckService extends AppService
{
    use CrudMethods;

    /**
     * @var UsersCheckRepository
     */
    protected $repository;

    public function __construct(UsersCheckRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->setPresenter(UsersCheckPresenter::class);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function all($limit = 20)
    {
      $completed = $this->repository->orderBy('created_at', 'desc')
        ->findWhere([
          'users_id' => Auth::user()->id,
          ['start', '>', Carbon::today()],
          ['end', '<', Carbon::tomorrow()],
        ])['data'];

      $uncompleted = $this->repository->orderBy('created_at', 'desc')
        ->findWhere([
          'users_id' => Auth::user()->id,
          'end' => null,
          ['start', '>=', Carbon::now()->format('Y-m-d 00:00:00')],
        ])['data'];

      return ['completed' => $completed, 'uncompleted' => count($uncompleted) > 0 ? $uncompleted[0] : $uncompleted];
    }

  /**
   * @param string $at
   * @return mixed
   */
    public function everyone(string $at): array
    {
      if (empty($at)) {
        return $this->repository->with('user')->orderBy('created_at', 'desc')->all();
      } else {
        $at = Carbon::createFromFormat('Y-m-d', Functions::convertDateToUS($at, false, false))->addDays(-1);
        return $this->repository
          ->with('user')
          ->orderBy('created_at', 'desc')
          ->findWhereBetween('start', [$at->ceilDay()->format('Y-m-d H:i:s'), $at->ceilDay()->addDays()->format('Y-m-d H:i:s')]);
      }

    }

    public function calendar(): array
    {
      $checks = $this->repository->skipPresenter(true)
        ->with(['user' => function ($q) { return $q->select(['name', 'id']); }])
        ->orderBy('created_at', 'desc')
        ->all();
      $days = [];

      foreach ($checks as $check) {
        $days[] = [
          'user' => $check['user']['name'],
          'start' => $check['start']->format('Y-m-d H:i:s'),
          'end' => $check['end']->format('Y-m-d H:i:s')
        ];
      }

      return $days;
    }

    /**
     * @param array $data
     * @param bool $skipPresenter
     * @return mixed
     */
    public function create(array $data)
    {
      $data['start'] = Carbon::now()->format('Y-m-d H:i:s');
      $data['users_id'] = Auth::user()->id;
      unset($data['_token']);

//      dd($data);
      return $this->repository->skipPresenter(true)->create($data);
    }

  /**
   * @param int $id
   * @return mixed
   */
    public function update(int $id)
    {
      return $this->repository->update(['end' => Carbon::now()->format('Y-m-d H:i:s')], $id);
    }
}
