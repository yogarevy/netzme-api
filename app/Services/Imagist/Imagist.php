<?php


namespace App\Services\Imagist;


use App\Services\Imagist\Repositories\ImagistRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Intervention\Image\Image;

class Imagist
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var ImagistRepository
     */
    public $image;

    /**
     * Tenant constructor.
     * @param $app
     * @param ImagistRepository $image
     */
    public function __construct($app, ImagistRepository $image)
    {
        $this->app = $app;
        $this->image = $image;
    }

    /**
     * @return ImagistRepository
     */
    public function image()
    {
        return $this->app['imagist.image'];
    }

    /**
     * @param UploadedFile|UploadedFile[]|array|null $image
     * @param string $dir
     * @return string
     * @throws \Exception
     */
    public function store($image, string $dir)
    {
        return $this->image->store($image, $dir);
    }

    /**
     * @param \App\Models\Image $model
     * @throws \Exception
     */
    public function delete(\App\Models\Image $model)
    {
        $this->image->delete($model);
    }

    /**
     * @param UploadedFile|UploadedFile[]|array|null $raw
     * @return Image
     */
    public function resize($raw)
    {
        return $this->image->resize($raw);
    }

    /**
     * @param UploadedFile|UploadedFile[]|array|null $image
     * @param \App\Models\Image $model
     * @param \string $dir
     * @return string
     * @throws \Exception
     */
    public function replace($image, \App\Models\Image $model, string $dir)
    {
        return $this->image->replace($image, $model, $dir);
    }
}
