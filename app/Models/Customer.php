<?php

namespace App\Models;

use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use UuidModel, SoftDeletes;

    public $table = 'customers';

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
        'name', 'username', 'status', 'photo', 'trx_count', 'trx_amount', 'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    public static function sql()
    {
        return self::select('*');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'photo', 'id');
    }
}
