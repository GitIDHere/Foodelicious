<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Database\Eloquent;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use App\Models\File as AppFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    /**
     * @var array
     */
    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
    ];
    
    /**
     * Max file size in MB
     * @var int 
     */
    protected $maxFileSizeMb = 1;
    
    /**
     * @var string 
     */
    protected $baseFilePath = '';
    
    /**
     * @var null|FilesystemAdapter
     */
    protected $driver = null;
    
    /**
     * @var string 
     */
    protected $thumbnailPath = 'thumb/';
    
    /**
     * @var string 
     */
    protected $tmpPath = 'img_tmp';
    
    
    const VISIBILITY_PUBLIC = 'public';
    
    
    /**
     * @param FilesystemAdapter $driver
     * @param $allowedMimeTypes
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }
    
    
    /**
     * @param UploadedFile[] $files
     * @param string $visibility
     * @param array $customNames
     * @return Eloquent\Collection
     * @throws \Exception
     */
    public function savePhotos($files, $customNames = [])
    {
        $this->checkDriverExists();
        
        $savedFiles = new Eloquent\Collection();
        
        foreach($files as $fileIndex => $file) 
        {
            // Check that the mime type is allowed
            if (in_array($file->getMimeType(), $this->allowedMimeTypes)) 
            {
                // Check that the size is in limit
                $fileSizeBytes = $file->getSize();
                $fileSizeMb = $this->getMbFromBytes($fileSizeBytes);
                
                if ($fileSizeMb > 0 && $fileSizeMb < $this->maxFileSizeMb) 
                {
                    $visibility = $this->driver->getVisibility($file->getPathname());
                    
                    // Check if the file needs custom name
                     if (isset($customNames[$fileIndex]) && !empty($customNames[$fileIndex])) 
                     {
                         $fileName = $customNames[$fileIndex];
                         $path = $this->driver->putFileAs($this->baseFilePath, new File($file->getPathname()), $fileName, $visibility);
                     } 
                     else {
                         $path = $this->driver->putFile($this->baseFilePath, new File($file->getPathname()), $visibility);
                     }
                     
                     if ($path) 
                     {
                        $fileName = basename($path);
                        
                        $savedFiles->add(AppFile::create([
                             'name' => $fileName,
                             'path' => $path
                         ]));
                     }
                }
            }
        }
        
        return $savedFiles;
    }
    
    
    /**
     * @param int width
     * @param int height
     * @param $imgPath
     * @throws \Exception
     */
    public function createThumbnail($width, $height, $imgPath)
    {
        $this->checkDriverExists();
        
        $thumbnailDir = $this->driver->path($this->thumbnailPath . $this->baseFilePath.'/');
        \Illuminate\Support\Facades\File::ensureDirectoryExists($thumbnailDir);
        createImage($thumbnailDir, $this->driver->path($imgPath), $width, $height);
    }
    
    /**
     * @param Recipe $recipe
     * @param [] $photoIds
     * * @throws \Exception
     */
    public function deletePhotos($recipe, $photoIds)
    {
        $this->checkDriverExists();
        
        if ($recipe instanceof Recipe && !empty($photoIds))
        {
            if (!is_array($photoIds)) {
                $photoIds = [$photoIds];
            }
            
            $recipe->files()->detach($photoIds);
        }
    }
    
    /**
     * @param FilesystemAdapter $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }
    
    /**
     * @throws \Exception
     */
    private function checkDriverExists()
    {
        if ( isset($this->driver) == false || ($this->driver instanceof FilesystemAdapter) == false) {
            throw new \Exception('Photo driver is not set');
        }
    }
    
    /**
     * @param $bytes
     * @return float
     */
    private function getMbFromBytes($bytes)
    {
        return $bytes * 0.000000954;
    }
    
    /**
     * @param string $baseFilePath
     */
    public function setBaseFilePath($baseFilePath)
    {
        $this->baseFilePath = $baseFilePath;
    }
    
    /**
     * @param $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }
    
}