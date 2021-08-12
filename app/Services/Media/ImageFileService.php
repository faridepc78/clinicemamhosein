<?php


namespace App\Services\Media;


use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageFileService extends DefaultFileService implements FileServiceContract
{
    public static function upload(UploadedFile $file, $filename, $dir, $public_folder, $private_folder): array
    {
        $path = $public_folder . '/' . $private_folder . '/';
        $full_path = $dir . $public_folder . '/' . $private_folder . '/';
        Storage::putFileAs($full_path, $file, $filename . '.' . $file->getClientOriginalExtension());
        $original_path = $path . $filename . '.' . $file->getClientOriginalExtension();
        return self::originalUpload($original_path);
    }

    private static function originalUpload($path)
    {
        $img['original'] = $path;
        return $img;
    }

    public static function getFilename()
    {
        return 'public/' . static::$media->files['original'];
    }

    public static function thumb()
    {
        return asset('assets/common/images/image-thumb.jpg');
    }

    public static function original(Media $media)
    {
        return "/storage/" . $media->files['original'];
    }
}

