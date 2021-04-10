<?php

namespace App\Services\Imagist\Facades;

use App\Models\Image;
use Illuminate\Support\Facades\Facade;

/**
 * Imagist service.
 *
 * @author     Thomas Andtianto
 * @license    MIT
 * @copyright  (c) 2019, Thomas Andrianto
 */

/**
 * @method image()
 * @method store($image, string $dir)
 * @method replace($image, Image $model, string $dir)
 * @method delete(Image $model)
 * @method resize($raw)
 */
class Imagist extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'imagist.facade';
    }
}
