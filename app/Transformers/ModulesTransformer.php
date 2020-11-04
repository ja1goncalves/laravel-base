<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Modules;

/**
 * Class ModulesTransformer.
 *
 * @package namespace App\Transformers;
 */
class ModulesTransformer extends TransformerAbstract
{
    /**
     * Transform the Modules entity.
     *
     * @param \App\Entities\Modules $model
     *
     * @return array
     */
  public function transform(Modules $model)
  {
    return [
      'id'         => (int) $model->id,
      'icon'       => $model->icon,
      'name'       => $model->name,
      'route'      => $model->route ?? '--',
      'status'     => $model->status,

      /* place your other model properties here */

      'created_at' => $model->created_at->format('d/m/Y'),
      'updated_at' => $model->updated_at->toDateTimeString()
    ];
  }
}
