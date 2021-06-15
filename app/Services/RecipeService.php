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
        }
        else {
            // Create new recipe
            $recipe = $userProfile->recipes()->create($recipeData);
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

            return [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'img_url' => $imgURL,
                'thumbnail' => $thumbnail,
                'date_created' => $recipe->created_at->format('d/m/Y'),
                'total_favourites' => 0,
            ];
        });

        return [
            'recipe_list' => $recipeList,
            'pager' => $pager
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
                'comment' => $comment->comment
            ];
        });

        $payload['comments'] = $commentList;
        $payload['total'] = count($comments);
        $payload['pager'] = $pager;
        $payload['has_commented'] = $pager;

        return $payload;
    }

}
