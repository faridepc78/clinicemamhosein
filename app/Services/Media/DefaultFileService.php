<?php


namespace App\Services\Media;


abstract class DefaultFileService
{
    public static $media;

    public static function delete($media)
    {
        foreach ($media->files as $file) {
            $key = 'uploads';
            if (empty($media->private_folder)) {
                unlink($key . '/' . $file);
            } else {
                unlink($key . '/' . $file);
                $full_path = $key . '/' . $media->public_folder . '/' . $media->private_folder;
                if (is_dir_empty($full_path)) {
                    rmdir($full_path);
                }
            }
        }
    }
}
