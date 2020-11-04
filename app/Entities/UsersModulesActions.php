<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UsersModulesActions.
 *
 * @package namespace App\Entities;
 */
class UsersModulesActions extends Model implements Transformable
{
  use TransformableTrait;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_module_id', 'action', 'auth'];


  public function userModule()
  {
    return $this->belongsTo(UsersModules::class, 'user_module_id', 'id');
  }
}
