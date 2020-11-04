<?php

namespace App\Entities;

use App\Observers\UsersModulesObserver;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UsersModules.
 *
 * @package namespace App\Entities;
 */
class UsersModules extends Model implements Transformable
{
  use TransformableTrait;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'module_id', 'auth'];

  public function user()
  {
    return $this->belongsTo(Users::class, 'user_id', 'id');
  }

  public function module()
  {
    return $this->belongsTo(Modules::class, 'module_id', 'id');
  }

  public function actions()
  {
    return $this->hasMany(UsersModulesActions::class, 'user_module_id', 'id');
  }

  public static function boot()
  {
    parent::boot();
    UsersModules::observe(UsersModulesObserver::class);
  }
}
