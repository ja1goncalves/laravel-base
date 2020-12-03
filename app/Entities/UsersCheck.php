<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UsersCheck.
 *
 * @package namespace App\Entities;
 */
class UsersCheck extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['users_id', 'start', 'end'];
    protected $dates = ['start', 'end'];

    public function user()
    {
        return $this->belongsTo(Users::class, 'users_id', 'id');
    }

}
