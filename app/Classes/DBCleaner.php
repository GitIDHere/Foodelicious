<?php namespace App\Classes;

use App\Models\File;
use App\Services\PhotoService;
use Illuminate\Support\Facades\Storage;

class DBCleaner
{
    /**
     * Purge Files that aren't attached to another model
     */
    public static function cleanFiles()
    {
        // Get all unattached Files
        $files = File::where('is_attached', false)->get();

        $publicVisibility = PhotoService::VISIBILITY_PUBLIC;

        $files->each(function($file) use ($publicVisibility)
        {
            // Remove the images
            $drive = Storage::drive();

            $drive->delete($publicVisibility . '/' . $file->path);
            $drive->delete($publicVisibility . '/thumbnails/' . $file->path);

            // Delete the entry
            $file->delete();
        });

    }


    public static function clean()
    {
        self::cleanFiles();
    }
}
