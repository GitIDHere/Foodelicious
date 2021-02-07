<?php

namespace App\Http\Controllers\API;

use App\Facades\APIResponse;
use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagListController extends Controller
{
    
    private $tagService;
    
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    
    /**
     * Get ingredients by matching term
     *
     * @param  string $ingredientTerm
     * @return \Illuminate\Http\Response
     */
    public function ingredientList(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string|max:150',
        ]);
        
        $term = $request->get('term');
        
        $ingredientList = $this->tagService->getListByTerm(Ingredient::class, 'name', $term);
        
        $list = [];
        foreach ($ingredientList as $ingredient){
            $list[] = $ingredient['name'];
        }
        
        return APIResponse::make(200, $list);
    }
    
}
