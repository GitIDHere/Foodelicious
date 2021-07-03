<?php namespace App\Http\Controllers\Recipe;

use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * @var RecipeService
     */
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return \Illuminate\Contracts\View\View
     */
    public function showRecipe(Request $request, Recipe $recipe)
    {
        $user = Auth::user();
        $userProfile = $user ? $user->userProfile : null;

        $pageData = $this->recipeService->getRecipeData($recipe, $userProfile);
        $recipeComments = $this->recipeService->getComments($recipe);

        return view('screens.recipe.view', [
            'recipe' => $pageData,
            'comments' => $recipeComments
        ]);
    }

    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return \Illuminate\Contracts\View\View
     */
    public function previewRecipe(Request $request, Recipe $recipe)
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;

        $pageData = $this->recipeService->getRecipeData($recipe, $userProfile);
        $recipeComments = $this->recipeService->getComments($recipe);

        // Declare a variable to denote that we are previewing the recipe
        $pageData['is_preview'] = true;

        return view('screens.recipe.view', [
            'recipe' => $pageData,
            'comments' => $recipeComments
        ]);
    }
}
