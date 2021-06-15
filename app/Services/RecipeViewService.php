<?php namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeComments;
use App\Models\RecipeFavourites;
use App\Models\UserProfile;

class RecipeViewService
{

    /**
     * @param UserProfile $userProfile
     * @param $recipeId
     * @param $commentId
     * @return bool|mixed|null
     */
    public function deleteComment(UserProfile $userProfile, $recipeId, $commentId)
    {
        // Get the user's comments for this recipe
        // Checks that the comment is linked to the recipe
        $comments = $userProfile->recipeComments()->where('recipe_id', $recipeId)->first();

        // There aren't any comments to delete
        if (empty($comments)) {
            return false;
        }

        // Check that the comment belongs to the user
        $comment = $comments->where('id', $commentId)->first();

        if ($comment)
        {
            // Delete comment
            return $comment->delete();
        }

        return false;
    }

    /**
     * @param UserProfile $userProfile
     * @param Recipe $recipe
     * @param $recipeComment
     * @return bool
     */
    public function saveComment(UserProfile $userProfile, Recipe $recipe, $recipeComment)
    {
        // Make sure the user hasn't already commented on this recipe
        $existingComment = $userProfile->recipeComments()->where('recipe_id', $recipe->id)->first();

        if (empty($existingComment))
        {
            $comment = RecipeComments::create([
                'user_profile_id' => $userProfile->id,
                'recipe_id' => $recipe->id,
                'comment' => removeTags($recipeComment)
            ]);

            return (bool)$comment;
        }

        return false;
    }


    /**
     * @param UserProfile $userProfile
     * @param Recipe $recipe
     */
    public function favourite(UserProfile $userProfile, Recipe $recipe)
    {
        // Get the current rating
        $favourite = $userProfile->recipeFavourites()->where('recipe_id', $recipe->id)->first();

        if (empty($favourite))
        {
            // If not found, then create
            $favourite = RecipeFavourites::create([
                'user_profile_id' => $userProfile->id,
                'recipe_id' => $recipe->id,
                'is_favourited' => 0
            ]);
        }

        // Toggle it - If 1 then 0
        $favourite->is_favourited = ($favourite->is_favourited ? 0 : 1);
        $favourite->save();
    }

}
