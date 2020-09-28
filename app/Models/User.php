<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @version June 17, 2020, 8:41 am UTC
 *
 * @property string $name
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, Notifiable;

    public $table = 'users';

    public $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function galleries()
    {
        return $this->hasMany('App\Models\Gallery');
    }
}
