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
    public function searchIngredient($searchTerm)
    {
        if (!empty($searchTerm) && is_string($searchTerm))
        {
            $baseDir = $this->baseDir;
            $ingredientJSON = getFileContents($baseDir, 'ingredients.json');

            $results = [];

            if (!empty($ingredientJSON))
            {
                $ingredients = json_decode($ingredientJSON);

                $searchTerm = strtolower($searchTerm);

                $results = Arr::where($ingredients, function($val, $key) use($searchTerm)
                {
                    return (stripos(strtolower($val), $searchTerm) !== false);
                });

            }

            $results = array_slice($results, 0, 5);

            return $results;
        }

        return [];
    }
}
