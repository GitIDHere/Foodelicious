<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class IngredientRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = Ingredient::all();
        $recipes = Recipe::all();
        
        foreach ($ingredients as $ingredient)
        {
            $recipe = $recipes->random(1);
            $ingredient->recipes()->attach($recipe);
        }
    }
}
