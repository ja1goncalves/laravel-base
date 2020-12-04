<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\UsersCheck;

/**
 * Class UsersCheckTransformer.
 *
 * @package namespace App\Transformers;
 */
class UsersCheckTransformer extends TransformerAbstract
{
    /**
     * Transform the UsersCheck entity.
     *
     * @param \App\Entities\UsersCheck $model
     *
     * @return array
     */
    public function transform(UsersCheck $model)
    {
        return [
          'id'         => (int) $model->id,
          'user'       => $model['user'] ?? [],
          'start'      => $model->start->format('d/m/Y H:i:s'),
          'end'        => $model->end ? $model->end->format('d/m/Y H:i:s') : null,
          'created_at' => $model->created_at->format('d/m/Y'),
          'updated_at' => $model->updated_at ? $model->updated_at->toDateTimeString() : null
        ];
    }
}
