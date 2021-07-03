<?php namespace App\Services;

use App\Models\Recipe;
use App\Models\UserProfile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UserRecipeService
{
    /**
     * @var int
     */
    private $recipeItemsPerPage = 9;

    /**
     * @param UserProfile $userProfile
     * @param Recipe $recipe
     * @param $recipeData
     * @return mixed|null
     */
    public function saveRecipe(UserProfile $userProfile, Recipe $recipe, $recipeData)
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

        return $recipe;
    }

    /**
     * @param UserProfile $userProfile
     * @return array
     */
    public function getPublicRecipeList(UserProfile $userProfile)
    {
        $userRecipes = $userProfile->recipes()->public()->get()->sortByDesc('created_at');
        return $this->generateRecipeList($userRecipes);
    }

    /**
     * @param UserProfile $userProfile
     * @param null $searchTerm
     * @return array
     */
    public function getRecipeList(UserProfile $userProfile, $searchTerm = null)
    {
        $userRecipes = $userProfile->recipes->sortByDesc('created_at');
        return $this->generateRecipeList($userRecipes, $searchTerm);
    }

    /**
     * @param UserProfile $userProfile
     * @return array
     */
    public function getFavourites(UserProfile $userProfile, $searchTerm = null)
    {
        /*
         * Get the Recipes related to the RecipeFavourites model
         */
        $favourites = $userProfile->recipeFavourites()->favourited()->with('Recipe')->get()->sortByDesc('created_at');

        $recipeList = collect();

        // Make sure that the favourited recipes are public
        $favourites->each(function($favourite) use(&$recipeList)
        {
            $recipe = $favourite->getRelation('Recipe');
            if ($recipe->is_published) {
                $recipeList->add($recipe);
            }
        });

        return $this->generateRecipeList($recipeList, $searchTerm);
    }


    /**
     * @param Collection $recipes
     * @param null $searchTerm
     * @return array
     */
    private function generateRecipeList(Collection $recipes, $searchTerm = null)
    {
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
            $commentCount = $recipe->recipeComments()->get()->count();

            return [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'title_url_formatted' => Str::replace(' ', '_', $recipe->title),
                'img_url' => $imgURL,
                'thumbnail' => $thumbnail,
                'date_created' => $recipe->created_at->format('d/m/Y'),
                'total_favourites' => $favouriteCount,
                'total_comments' => $commentCount,
            ];
        });

        return [
            'recipe_list' => $recipeList,
            'pager' => $pager
        ];
    }
}
