<?php

namespace App\Services;

use App\Models\File;
use App\Models\Recipe;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    private $recipePhotoService;

    /**
     * @var int
     */
    private $recipeItemsPerPage = 10;

    private $commentsPerPage = 5;

    public function __construct(RecipePhotoService $recipePhotoService)
    {
        $this->recipePhotoService = $recipePhotoService;
    }

    /**
     * @param $userProfile
     * @param $recipe
     * @param $recipeData
     * @param $savePhotos
     * @return mixed|null
     * @throws \Exception
     */
    public function saveRecipe($userProfile, $recipe, $recipeData, $savePhotos)
    {
        // Check $recipe is already attached to the user
        $isUserRecipe = $userProfile->recipes->contains($recipe);

        if ($isUserRecipe) {
            // Update the recipe
            $recipe->fill($recipeData)->save();
            $recipe->recipeMetadata->fill($recipeData)->save();
        }
        else {
            // Create new recipe
            $recipe = $userProfile->recipes()->create($recipeData);
            $recipe->recipeMetadata()->create($recipeData);
        }

        if ($recipe)
        {
            $savedFiles = $this->recipePhotoService->savePhotos($savePhotos);

            if ($savedFiles->isNotEmpty())
            {
                $savedFiles->each(function($file)
                {
                    $this->recipePhotoService->makeThumbnail($file->path);
                });

                $recipe->files()->attach($savedFiles);
            }

            return $recipe;
        }

        return null;
    }

    /**
     * @param $recipe
     * @param $photosToDeleteIds
     * @throws \Exception
     */
    public function deletePhotos($recipe, $photosToDeleteIds)
    {
        $this->recipePhotoService->deletePhotos($recipe, $photosToDeleteIds);
    }


    /**
     * @param UserProfile $userProfile
     * @param string|null $searchTerm
     * @return array
     */
    public function getRecipeList(UserProfile $userProfile, $searchTerm = null)
    {
        $recipes = $userProfile->recipes->sortByDesc('created_at');

        $recipeList = $recipes->filter(function($recipe) use ($searchTerm)
        {
            // If the search term is empty, then include the recipe, because we aren't searching
            return (empty($searchTerm) || stripos($recipe->title, $searchTerm) !== false);
        });

        $pager = collectionPaginate($recipeList, $this->recipeItemsPerPage);

        // Get the items out of the pager
        $recipeItems = collect($pager->items);

        $recipeList = $recipeItems->map(function($recipe)
        {
            $recipePhoto = $recipe->files->first();

            $imgURL = $thumbnail = '';
            if(is_object($recipePhoto)) {
                $imgURL = asset($recipePhoto->public_path);
                $thumbnail = asset($recipePhoto->thumbnail_path);
            }

            $favouriteCount = $recipe->recipeFavourites()->where('is_favourited', 1)->get()->count();

            return [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'img_url' => $imgURL,
                'thumbnail' => $thumbnail,
                'date_created' => $recipe->created_at->format('d/m/Y'),
                'total_favourites' => $favouriteCount,
            ];
        });

        return [
            'recipe_list' => $recipeList,
            'pager' => $pager
        ];
    }


    /**
     * @param Recipe $recipe
     * @param UserProfile|null $userProfile
     * @return array
     */
    public function getRecipeData(Recipe $recipe, UserProfile $userProfile = null)
    {
        /**
         * - Photos
         * X- Stars/Thumbs ups
         * X- Comments
         * X- Ingredients
         * X- Title
         * X- Cooking steps
         * X- Date created
         * X- Utensils
         * X- Description
         * X- Cook time
         * X- User details (username)
         *  - View user profile. Only the public recipes
         */


        $recipePhotos = $recipe->files->map(function($file)
        {
            return asset($file->public_path);
        })->toArray();

        $favouriteCount = $recipe->recipeFavourites()->where('is_favourited', 1)->get()->count();

        $isFavourited = false;

        // Get the favourite record for the user for this recipe
        if ($userProfile)
        {
            // Check if this recipe belongs to the user
            if ($userProfile->recipes->contains($recipe->id))
            {
                $favourites = $userProfile->recipeFavourites()->where('recipe_id', $recipe->id)->first();
                $isFavourited = ($favourites && $favourites->is_favourited ?: false);
            }
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
            'username' => $recipe->userProfile->username,
            'ingredients' => $recipe->ingredients,
            'photos' => $recipePhotos,
            'is_favourited' => $isFavourited,
            'is_published' => $recipe->is_published,
            'enable_comments' => $recipe->enable_comments
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
