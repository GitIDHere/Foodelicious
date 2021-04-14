<?php namespace App\Services;


use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class ProfilePhotoService extends PhotoService
{
    /**
     * @var string
     */
    protected $baseFilePath = 'profile_pics';
    
    
    public function __construct($driver)
    {
        parent::__construct($driver);
    }
    
    
    /**
     * @param UploadedFile $img
     * @param int $cropWidth
     * @param int $cropHeight
     * @param int $cropX
     * @param int $cropY
     */
    public function cropImage($img, $cropWidth, $cropHeight, $cropX, $cropY)
    {
        $targetW = 500;
        $targetH = 500;
        
        $dir = $this->driver->path($this->baseFilePath.'/');
        
        $imgPath = $this->driver->putFile($this->tmpPath, new File($img->getPathname()), 'private');
        
        cropImage($dir, $this->driver->path($imgPath), $targetW, $targetH, $cropWidth, $cropHeight, $cropX, $cropY);
    }
    
    
}