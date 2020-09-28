<?php

namespace App\Models;

use Eloquent as Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class Category
 * @package App\Models
 * @version June 17, 2020, 9:01 am UTC
 *
 * @property string $name
 */
class Category extends Model
{
    use CrudTrait;

    public $table = 'categories';

    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function acticles()
    {
        return $this->hasMany('App\Models\Article');
    }
}
