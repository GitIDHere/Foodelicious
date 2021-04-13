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
    
        $scaleX = ($targetW / $cropWidth);
        $scaleY = ($targetH / $cropHeight);
    
        if ($scaleX < $scaleY) {
            # if the height needs to be scaled.
            # shrink y to match x scale
            $targetH = ($cropHeight * $scaleX);
            $targetW = ($cropWidth * $scaleX);
        } else {
            # shrink y to match x scale
            $targetH = ($cropHeight * $scaleY);
            $targetW = ($cropWidth * $scaleY);
        }
        
        $dir = $this->driver->path($this->baseFilePath.'/');
        
        $imgPath = $this->driver->putFile($this->tmpPath, new File($img->getPathname()), 'private');
        
        createImage($dir, $this->driver->path($imgPath), $targetW, $targetH, $cropX, $cropY);
    }
    
    
}