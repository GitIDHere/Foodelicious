<?php namespace App\Services;

use Illuminate\Support\Arr;

class TagService
{
    private $baseDir;


    public function __construct()
    {
        $this->baseDir = database_path('entries');
    }


    /**
     * @param $searchTerm
     * @return array
     */
    public function searchForUtensil($searchTerm)
    {
        return $this->searchFile($searchTerm, 'utensils.json');
    }

    /**
     * @param $searchTerm
     * @return array
     */
    public function searchForIngredient($searchTerm)
    {
        return $this->searchFile($searchTerm, 'ingredients.json');
    }


    /**
     * @param $searchTerm
     * @param $fileName
     * @return array
     */
    private function searchFile($searchTerm, $fileName)
    {
        if (!empty($searchTerm) && is_string($searchTerm))
        {
            $baseDir = $this->baseDir;
            $jsonStr = getFileContents($baseDir, $fileName);

            $results = [];

            if (!empty($jsonStr))
            {
                $fileList = json_decode($jsonStr);

                $searchTerm = strtolower($searchTerm);

                $results = Arr::where($fileList, function($val, $key) use($searchTerm)
                {
                    return (stripos(strtolower($val), $searchTerm) !== false);
                });

            }

            return array_slice($results, 0, 5);
        }

        return [];
    }
}
