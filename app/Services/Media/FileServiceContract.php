<?php


namespace App\Services\Media;


use App\Models\Media;
use Illuminate\Http\UploadedFile;

interface FileServiceContract
{
    public static function upload(UploadedFile $file, string $filename, string $dir,
                                  string $public_folder, string $private_folder): array;

    public static function delete(Media $media);
}
