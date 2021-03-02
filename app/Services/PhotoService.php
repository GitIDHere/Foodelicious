<?php

namespace App\Services;



use App\Models\Recipe;
use Illuminate\Database\Eloquent;
use Illuminate\Http\File;
use App\Models\File as AppFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    /**
     * @var array
     */
    protected $allowedMimeTypes;
    
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
     * @var string 
     */
    protected $visibility = 'public';
    
    
    /**
     * @param $allowedMimeTypes
     */
    public function __construct($allowedMimeTypes)
    {
        $this->allowedMimeTypes = $allowedMimeTypes;
    }
    
    
    /**
     * @param UploadedFile[] $files
     * @param array $customNames
     * @return Eloquent\Collection
     */
    public function savePhotos($files, $customNames = [])
    {
        $savedFiles = new Eloquent\Collection();
        
        $driver = Storage::drive($this->visibility);
        
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
                    // Check if the file needs custom name
                     if (isset($customNames[$fileIndex]) && !empty($customNames[$fileIndex])) 
                     {
                         $fileName = $customNames[$fileIndex];
                         $path = $driver->putFileAs($this->baseFilePath, new File($file->getPathname()), $fileName, $this->visibility);
                     } 
                     else {
                         $path = $driver->putFile($this->baseFilePath, new File($file->getPathname()), $this->visibility);    
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
     * @param Recipe $recipe
     * @param [] $photoIds
     */
    public function deletePhotos($recipe, $photoIds)
    {
        if ($recipe instanceof Recipe && !empty($photoIds))
        {
            if (!is_array($photoIds)) {
                $photoIds = [$photoIds];
            }
            
            $recipe->files()->detach($photoIds);
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