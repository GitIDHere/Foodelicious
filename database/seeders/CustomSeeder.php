<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomSeeder extends Seeder
{
    protected $directory;
    
    
    public function __construct()
    {
        $this->directory = database_path('entries');
    }
    
    
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }
    
    /**
     * @param $fileName
     * @return false|string|null
     */
    private function loadDataFile($fileName)
    {
        $dir = $this->directory;
        
        if (file_exists($dir . '/' . $fileName)){
            return file_get_contents($dir . '/' . $fileName);
        }
        
        return null;
    }
    
    /**
     * @param $fileName
     * @return mixed
     */
    public function fromJSON($fileName)
    {
        // Check if the extention is present or not
        $ext = '';
        if (strtolower(mb_substr($fileName, -5)) !== '.json') {
            $ext = '.json';    
        }
        
        $fileContent = $this->loadDataFile($fileName.$ext);
        return json_decode($fileContent);
    }
    

}
