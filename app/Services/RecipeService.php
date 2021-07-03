<?php namespace App\Services;

use App\Models\Recipe;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class RecipeService
{
    /**
     * @var int
     */
    private $commentsPerPage = 5;


    /**
     * @param Recipe $recipe
     * @param UserProfile|null $userProfile
     * @return array
     */
    public function getRecipeData(Recipe $recipe, UserProfile $userProfile = null)
    {
        $recipePhotos = $recipe->files->map(function($file)
        {
            return asset($file->public_path);
        })->toArray();

        $favouriteCount = $recipe->recipeFavourites()->where('is_favourited', 1)->get()->count();

        $isFavourited = false;

        // Get the favourite record for the user for this recipe
        if ($userProfile)
        {
            // Is this recipe favourited by the user viewing the recipe?
            $favourite = $userProfile->recipeFavourites()->where('recipe_id', $recipe->id)->first();
            $isFavourited = ($favourite && $favourite->is_favourited == 1 ?: false);
        }

        $profilePic = null;
        $recipeUser = $recipe->userProfile;

        if ($recipeUser) {
            $profilePic = $recipeUser->files->first();
        }

        return [
            'id' => $recipe->id,
            'title' => $recipe->title,
            'description' => $recipe->description,
            'favourites' => $favouriteCount,
            'servings' => $recipe->servings,
            'cooking_steps' => $recipe->cooking_steps,
            'date_created' => $recipe->created_at,
            'utensils' => $recipe->utensils,
            'cook_time' => $recipe->cook_time_formatted,
            'ingredients' => $recipe->ingredients,
            'photos' => $recipePhotos,
            'is_favourited' => $isFavourited,
            'is_published' => $recipe->is_published,
            'enable_comments' => $recipe->enable_comments,
            'user' => [
                'username' => $recipe->userProfile->username,
                'profile_pic' => (is_object($profilePic) ? asset($profilePic->public_path) : null)
            ]
        ];
    }


    /**
     * @param Recipe $recipe
     * @return array
     */
    public function getComments(Recipe $recipe)
    {
        $payload = [
            'comments' => [],
            'total' => 0,
            'pager' => null,
            'has_commented' => false
        ];

        $user = Auth::user();

        if (!$user) return $payload;

        $userProfile = $user->userProfile;

        $userComment = $userProfile->recipeComments()->where('recipe_id', $recipe->id)->first();
        $payload['has_commented'] = (!empty($userComment));

        $comments = $recipe->recipeComments->sortByDesc('created_at');

        $pager = collectionPaginate($comments, $this->commentsPerPage, 'comment-page');

        // Get the items out of the pager
        $pagerItems = collect($pager->items);

        $commentList = $pagerItems->map(function($comment) use ($userProfile)
        {
            $commentUserProfile = $comment->userProfile;

            $username = $commentUserProfile->username;

            // If this comment belongs to the user viewing it.
            $allowDelete = ($userProfile->id == $comment->userProfile->id);

            return [
                'id' => $comment->id,
                'username' => $username,
                'allow_delete' => $allowDelete,
                'date' => $comment->created_at->format('d/m/Y'),
                'comment' => $comment->comment,
                'recipe_id' => $comment->recipe_id,
            ];
        });

        $payload['comments'] = $commentList;
        $payload['total'] = count($comments);
        $payload['pager'] = $pager;

        return $payload;
    }

}
