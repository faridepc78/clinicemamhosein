<?php


namespace App\Services\Media;


use App\Models\Media;
use Illuminate\Http\UploadedFile;

class ImageFileService extends DefaultFileService implements FileServiceContract
{
    public static function upload(UploadedFile $file, $filename, $dir, $public_folder, $private_folder): array
    {
        $path = $public_folder . '/' . $private_folder . '/';
        $full_path = $dir . $public_folder . '/' . $private_folder . '/';
        $file->move(public_path($full_path), $filename . '.' . $file->getClientOriginalExtension());
        $original_path = $path . $filename . '.' . $file->getClientOriginalExtension();
        return self::originalUpload($original_path);
    }

    private static function originalUpload($path)
    {
        $img['original'] = $path;
        return $img;
    }

    public static function original(Media $media)
    {
        return '/uploads/' . $media->files['original'];
    }
}

