<?php namespace App\Services;


use App\Models\Recipe;

class HomeService
{

    /**
     * @return array
     */
    public function mostFavouritedRecipes($limit)
    {
        $mostFavourited = Recipe::public()
            ->withCount('recipeFavourites')
            ->orderByDesc('recipe_favourites_count')
            ->limit($limit)
            ->get()
        ;

        return $this->processResults($mostFavourited);
    }

    /**
     * @param $limit
     * @return array
     */
    public function mostCommentedRecipes($limit)
    {
        $mostCommented = Recipe::public()
            ->withCount('recipeComments')
            ->orderByDesc('recipe_comments_count')
            ->limit($limit)
            ->get()
        ;

        return $this->processResults($mostCommented);
    }

    /**
     * @param $limit
     * @return array
     */
    public function mostRecentRecipes($limit)
    {
        $recentRecipes = Recipe::public()
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
        ;

        return $this->processResults($recentRecipes);
    }


    /**
     * @param $recipeResults
     * @return array
     */
    private function processResults($recipeResults)
    {
        $list = [];

        $recipeResults->each(function($recipe) use(&$list)
        {
            $recipePhoto = $recipe->files->first();
            $thumbnail = '';
            if(is_object($recipePhoto)) {
                $thumbnail = asset($recipePhoto->thumbnail_path);
            }

            $list[] = [
                'title' => $recipe->title,
                'username' => $recipe->userProfile->username,
                'thumbnail' => $thumbnail,
                'recipe_id' => $recipe->id
            ];
        });

        return $list;
    }

}
