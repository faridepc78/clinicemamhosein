<?php


namespace App\Services\Media;


use App\Models\Media;
use Illuminate\Http\UploadedFile;

class MediaFileService
{
    private static $file;
    private static $dir;
    private static $public_folder;
    private static $private_folder;

    public static function publicUpload(UploadedFile $file, string $public_folder,
                                        string $private_folder = null)
    {
        self::$file = $file;
        self::$dir = 'uploads/';
        self::$public_folder = $public_folder;
        self::$private_folder = $private_folder;
        return self::upload();
    }

    private static function upload()
    {
        $extension = self::normalizeExtension(self::$file);
        foreach (config('mediaFile.MediaTypeServices') as $type => $service) {
            if (in_array($extension, $service['extensions'])) {
                return self::uploadByHandler(new $service['handler'], $type);
            }
        }
    }

    public static function delete(Media $media)
    {
        foreach (config('mediaFile.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::delete($media);
            }
        }
    }

    private static function normalizeExtension($file): string
    {
        return strtolower($file->getClientOriginalExtension());
    }

    private static function filenameGenerator()
    {
        return uniqid();
    }

    private static function uploadByHandler(FileServiceContract $service, $key): Media
    {
        $media = new Media();
        $media->files = $service::upload(self::$file, self::filenameGenerator(), self::$dir,
            self::$public_folder, self::$private_folder);
        $media->type = $key;
        $media->filename = self::$file->getClientOriginalName();
        $media->public_folder = self::$public_folder;
        $media->private_folder = self::$private_folder;
        $media->save();
        return $media;
    }

    public static function original(Media $media)
    {
        foreach (config('mediaFile.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::original($media);
            }
        }
    }
}
