<?php

namespace App\Services;

use Illuminate\Filesystem\FilesystemAdapter;

class RecipePhotoService extends PhotoService
{
    /**
     * @var string 
     */
    protected $baseFilePath = 'recipes';
    
    /**
     * @var int 
     */
    protected $thumbnailWidth = 150;
    
    /**
     * @var int 
     */
    protected $thumbnailHeight = 150;
    
    /**
     * @param FilesystemAdapter $driver
     */
    public function __construct($driver)
    {
        parent::__construct($driver);
    }
    
    /**
     * @param $imgPath
     * @throws \Exception
     */
    public function makeThumbnail($imgPath)
    {
        parent::createThumbnail($this->thumbnailWidth, $this->thumbnailHeight, $imgPath);
    }
    
}