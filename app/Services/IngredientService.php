<?php

namespace App\Services;

use App\Models\Ingredient;

class IngredientService
{
    
    /**
     * @param $term
     * @return array
     */
    public function getListByTerm($term)
    {
        if (!empty($term) && is_string($term))
        {
            return Ingredient::where('name', 'LIKE', $term.'%')
                ->orderBy('name')
                ->take(5)
                ->get()
                ->toArray()
                ;   
        }
        return [];
    }
}