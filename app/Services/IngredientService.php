<?php

namespace App\Services;

use App\Models\Ingredient;

class IngredientService
{
    /**
     * @param $term
     * @return mixed
     */    
    public function getListByTerm($term)
    {
        return Ingredient::where('name', 'LIKE', '%'.$term.'%')
            ->orderBy('name')
            ->take(5)
            ->get()
        ;
    }
}