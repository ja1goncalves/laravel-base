<?php

namespace App\Transformers;

use App\Util\Functions;
use App\Util\UserRoleEnum;
use App\Util\UserStatusEnum;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Entities\Users;

/**
 * Class UsersTransformer.
 *
 * @package namespace App\Transformers;
 */
class UsersTransformer extends TransformerAbstract
{
    /**
     * Transform the Users entity.
     *
     * @param \App\Entities\Users $model
     *
     * @return array
     */
  public function transform(Users $model)
  {
    return [
      'id'         => (int) $model->id,
      'name'       => $model->name,
      'email'      => $model->email,
      'checks'     => $this->checks($model['checks']),
      'status'     => UserStatusEnum::getName($model->status),
      'role'       => UserRoleEnum::getUserRoles($model->role) ?? 'public',
      'modules'    => $model['modules'],
      /* place your other model properties here */

      'created_at' => $model->created_at->format('d/m/Y'),
      'updated_at' => $model->updated_at->toDateTimeString()
    ];
  }

  public function checks($checks)
  {
    $days = [];
    foreach ($checks as $check) {
      $day = $check['start']->format('d/m/Y');
      if (!key_exists($day, $days)) {
        $days[$day] = [
          'hours' => Functions::subtractDateTime($check['end'], $check['start']),
          'start' => $check['start']->format('d/m/Y H:i:s'),
          'end' => $check['end']->format('d/m/Y H:i:s')
        ];
      } else {
        $days[$day]['hours'] = Functions::sumDatetime($days[$day]['hours'], Functions::subtractDateTime($check['end'], $check['start']));
        $days[$day]['end'] = $check['end']->format('d/m/Y H:i:s');
      }
    }

    return $days;
  }
}
