<?php namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeRatings;
use App\Models\UserProfile;

class RecipeRatingService
{

    public function toggleRating(UserProfile $userProfile, Recipe $recipe)
    {
        // Get the current rating
        $rating = $userProfile->recipeRatings()->where('recipe_id', $recipe->id)->first();

        if (empty($rating))
        {
            // If not found, then create
            $rating = RecipeRatings::create([
                'user_profile_id' => $userProfile->id,
                'recipe_id' => $recipe->id,
                'rating' => 0
            ]);
        }

        // Toggle it - If 1 then 0
        $rating->rating = ($rating->rating ? 0 : 1);
        $rating->save();
    }

}
