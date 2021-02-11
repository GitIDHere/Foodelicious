<?php

namespace App\Services;

class RecipePhotoService extends PhotoService
{
    protected $allowedMimeTypes = [
        'image/jpeg',  
        'image/png', 
    ];
    
    protected $baseFilePath = 'recipes';

    public function __construct()
    {
        parent::__construct($this->allowedMimeTypes);
    }
    
}