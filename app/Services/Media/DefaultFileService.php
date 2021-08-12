<?php


namespace App\Services\Media;


use Illuminate\Support\Facades\Storage;

abstract class DefaultFileService
{
    public static $media;

    public static function delete($media)
    {
        foreach ($media->files as $file) {
            $key = 'public';
            if (empty($media->private_folder)) {
                Storage::delete($key . '\\' . $file);
            } else {
                Storage::delete($key . '\\' . $file);
                $full_path = $key . '/' . $media->public_folder . '/' . $media->private_folder;
                if (empty(Storage::allFiles($full_path))) {
                    Storage::deleteDirectory($full_path);
                }
            }
        }
    }

    abstract static function getFilename();
}
