<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    
    
    public function __construct()
    {
        
    }
    
    
    public function createRecipe(Request $request)
    {
        dd("Recipe submitted");
    }
    
    
    
}
