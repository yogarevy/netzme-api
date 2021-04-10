<?php

namespace App\Models;

use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use UuidModel;

    public $table = 'images';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path'
    ];

    public static function sql()
    {
        return self::select('*');
    }

    /**
     * Get the image's full url.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return Storage::url('public/' . $this->attributes['path']);
    }

    public function getPathAttribute()
    {
        return $this->attributes['path'];
    }
}
