<?php

namespace App\Http\Controllers\User;

use App\Classes\DBCleaner;
use App\Events\RecipeCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeCreateRequest;
use App\Models\File;
use App\Models\Recipe;
use App\Models\User;
use App\Services\RecipePhotoService;
use App\Services\RecipeService;
use App\Services\UserRecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserRecipeController extends Controller
{
    /**
     * @var UserRecipeService
     */
    private $userRecipeService;

    /**
     * @var int
     */
    private $recipeItemsPerPage = 10;


    public function __construct(UserRecipeService $userRecipeService)
    {
        $this->userRecipeService = $userRecipeService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View
     */
    public function showRecipeList()
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->userProfile;

        $recipeList = $this->userRecipeService->getRecipeList($profile);

        return view('screens.user.recipes.list')
            ->with('recipeList', $recipeList['recipe_list'])
            ->with('recipeListPager', $recipeList['pager'])
            ;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function searchRecipe(Request $request)
    {
        $validated = $request->validate([
            'search_term' => 'nullable|string|min:1|max:60',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $userProfile = $user->userProfile;

        $searchTerm = $request->get('search_term');

        // If the search term is empty, then redirect them to the full recipe list
        if(empty($searchTerm)) {
            return redirect()->route('user.recipes.list');
        }

        $recipes = $this->userRecipeService->getRecipeList($userProfile, $searchTerm);

        return view('screens.user.recipes.list')
            ->with('recipeList', $recipes['recipe_list'])
            ->with('recipeListPager', $recipes['pager'])
            ->with('searchTerm', $searchTerm)
            ;
    }

    /**
     * @param RecipeCreateRequest $request
     * @param $username
     * @param Recipe $recipe
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function saveRecipe(RecipeCreateRequest $request, $username, Recipe $recipe)
    {
        $recipeFields = $request->all();

        /** @var User $user */
        $user = Auth::user();
        $userProfile = $user->userProfile;

        if ($userProfile)
        {
            $uuid = $request->input('uuid');

            if (is_array($recipeFields['cooking_steps'])) {
                $recipeFields['cooking_steps'] = json_encode($recipeFields['cooking_steps']);
            }

            $recipeFields['is_published'] = $request->get('is_published') ? 1 : 0;
            $recipeFields['enable_comments'] = $request->get('enable_comments') ? 1 : 0;

            $recipe = $this->userRecipeService->saveRecipe($userProfile, $recipe, $recipeFields);

            if ($recipe)
            {
                // Dispatch event
                RecipeCreated::dispatch($uuid, $recipe);

                return redirect()->route('user.recipes.list')->with(['success' => 'Recipe added!']);
            }
            else {
                return back()->withErrors(['Failed to create recipe']);
            }
        }
        else {
            return redirect()->route('login.show')->withErrors(['User profile not found.']);
        }
    }


    /**
     * @param Request $request
     * @param $username
     * @param Recipe $recipe
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function viewRecipe(Request $request, $username, Recipe $recipe)
    {
        /** @var User $user */
        $user = Auth::user();
        $isUserRecipe = $user->userProfile->recipes->contains($recipe);

        // Remove any temp photo IDs from the session
        $request->session()->forget(RecipePhotoService::TEMP_PHOTO_SESSION_KEY);

        if ($isUserRecipe)
        {
            $ingredientsCSV = getCSVFromJSON($recipe->ingredients);
            $utensilsCSV = getCSVFromJSON($recipe->utensils);

            $cookTime = $recipe->cook_time;

            $recipePhotos = $recipe->files->map(function($photoFile)
            {
                return  [
                    'id' => $photoFile->id,
                    'uri' => asset($photoFile->public_path),
                    'alt' => $photoFile->name
                ];
            });

            $recipeData = [
                'title' => $recipe->title,
                'description' => $recipe->description,
                'cooking_steps' => $recipe->cooking_steps,
                'cook_time' => $cookTime,
                'servings' => $recipe->servings,
                'preparations' => $recipe->prep_directions,
                'utensils' => $utensilsCSV,
                'ingredients' => $ingredientsCSV,
                'photos' => $recipePhotos->toArray(),
                'is_published' => $recipe->is_published,
                'enable_comments' => $recipe->enable_comments,
            ];

            return view('screens.user.recipes.view', ['data' => $recipeData, 'recipe' => $recipe]);
        }
        else {
            // The recipe doesn't belong to the user
            return redirect()->route('home');
        }
    }

}
