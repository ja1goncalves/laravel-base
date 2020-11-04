<?php


namespace App\Util;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class FilesImages
{

    /**
     * @param UploadedFile $picture
     * @param string $name
     * @param string $class
     * @param bool $resize
     * @return string
     */
    public static function saveImage(UploadedFile $picture, $name, $class = 'Brands', $resize = false): string
    {
        $mime_type = explode("/", $picture->getMimeType())[1];
        $name = "$name.$mime_type";
        $path = "public/images/$class";

        Storage::putFileAs("public/images/$class", $picture, $name);
        if ($resize) self::resizePicture(storage_path("app/$path/$name"));

        return "$path/$name";
    }

    /**
     * @param string $picture_path
     * @return \Intervention\Image\Image
     */
    public static function resizePicture($picture_path): \Intervention\Image\Image
    {
        $resize_image = \Intervention\Image\Facades\Image::make($picture_path);
        $resize_image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        return $resize_image;
    }

    /**
     * @param $public_path
     * @return bool
     */
    public static function deleteFileImage($public_path = '')
    {
        return $public_path ? Storage::delete($public_path): false;
    }
}
