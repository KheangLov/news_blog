<?php

namespace App\Models;

use Eloquent as Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\Storage;

/**
 * Class Article
 * @package App\Models
 * @version June 17, 2020, 9:05 am UTC
 *
 * @property string $name
 * @property string $content
 * @property int $created_by
 * @property int $category_id
 */
class Article extends Model
{
    use CrudTrait;

    public $table = 'articles';

    public $fillable = [
        'name',
        'content',
        'thumbnail',
        'created_by',
        'category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'content' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function setThumbnailAttribute($value)
    {
        // $attribute_name = "thumbnail";
        // $disk = "public";
        // $destination_path = 'uploads/thumbnail';
        // dd($value->getClientOriginalName());
        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
        // $new_file_name = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        // $value->move(public_path($destination_path), $new_file_name);
        // $value->storeAs($destination_path, $new_file_name, $disk);

        // $image = $value;
        // $input['thumbnail'] = $image->getClientOriginalName();
        // $img = \Image::make($image->getRealPath());

        // $destinationPath = public_path('/uploads/thumbnail');

        // $image->move($destinationPath, $input['thumbnail']);
        // $this->attributes['thumbnail'] = $input['thumbnail'];

        $attribute_name = "thumbnail";
        $disk = "uploads";
        $destination_path = "uploads/thumbnail";

        $file = Storage::disk($disk)->put($destination_path, $value);
        $this->attributes[$attribute_name] = $file;
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
