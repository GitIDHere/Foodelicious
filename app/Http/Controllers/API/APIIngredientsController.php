<?php

namespace App\Http\Controllers\API;

use App\Facades\APIResponse;
use App\Http\Controllers\Controller;
use App\Services\IngredientService;
use Illuminate\Http\Request;

class APIIngredientsController extends Controller
{
    
    private $ingredientService;
    
    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }
    
    /**
     * - Check the return codes work
     * - Check handle exceptions
     * - 
     */
    
    
    /**
     * Get ingredients by matching term
     *
     * @param  string $ingredientTerm
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|string|min:1|max:150',
        ]);
        
        $term = $request->get('term');
        
        $ingredientCollection = $this->ingredientService->getListByTerm($term);
        
        $ingredientList = [];
        foreach ($ingredientCollection->toArray() as $ingredient)
        {
            $ingredientList[$ingredient['id']] = $ingredient['name'];
        }
        return APIResponse::make(200, $ingredientList);
    }
    
}
