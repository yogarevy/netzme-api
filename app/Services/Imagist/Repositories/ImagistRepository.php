<?php


namespace App\Services\Imagist\Repositories;


use App\Models\Image as ImageModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Webpatser\Uuid\Uuid;

class ImagistRepository
{
    /**
     * @param UploadedFile|UploadedFile[]|array|null $image
     * @param ImageModel $model
     * @param string $dir
     * @return string
     * @throws \Exception
     */
    public function replace($image, ImageModel $model, string $dir)
    {
        $this->delete($model);
        $resize = $this->resize($image);
        $dir = 'public/' . config('imagist.base_dir') . $dir;
        $ext = $image->getClientOriginalExtension();
        $full = $dir . '/' . Str::random(40) . '.' . $ext;
        Storage::disk(config('imagist.disk'))->put($full, $resize->encode());
        $model->update([
            'path' => $full
        ]);
        return $model->id;
    }

    /**
     * @param UploadedFile|UploadedFile[]|array|null $image
     * @param string $dir
     * @return string
     * @throws \Exception
     */
    public function store($image, string $dir)
    {
        $resize = $this->resize($image);
        $dir = 'public/' . config('imagist.base_dir') . $dir;
//        $ext = $image->getClientOriginalExtension();
        $full = $dir . '/' . Str::random(40) . '.jpg';
        Storage::disk('public')->put($full, $resize->encode());
        $modelImage = new ImageModel;
        $modelImage->id = Uuid::generate(4)->string;
        $modelImage->path = $full;
        $modelImage->save();
        $imageId = $modelImage->id;
        return $imageId;
    }

    /**
     * @param ImageModel $model
     * @throws \Exception
     */
    public function delete(ImageModel $model)
    {
        Storage::disk(config('imagist.disk'))->delete($model->path);
    }

    /**
     * @param UploadedFile|UploadedFile[]|array|null $raw
     * @return \Intervention\Image\Image
     */
    public function resize($raw)
    {
        $standard = 1280;
        $image = Image::make($raw);
        $width = $image->getWidth();
        $height = $image->getHeight();
        if ($width > $height) {
            // landscape
            if ($width > $standard) {
                $image = $image->resize($standard, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        } else {
            // portrait
            if ($height > $standard) {
                $image = $image->resize(null, $standard, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }
        return $image;
    }
}
