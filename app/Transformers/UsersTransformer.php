<?php

namespace App\Transformers;

use App\Util\UserStatusEnum;
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
      'status'     => UserStatusEnum::getName($model->status),
      'role'       => $model->role ?? 'public',
      'modules'    => $model['modules'],
      /* place your other model properties here */

      'created_at' => $model->created_at->format('d/m/Y'),
      'updated_at' => $model->updated_at->toDateTimeString()
    ];
  }
}
