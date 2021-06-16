<?php

namespace App\Http\Controllers\User;

use App\Events\RecipeCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeCreateRequest;
use App\Models\File;
use App\Models\Recipe;
use App\Models\User;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserRecipeController extends Controller
{
    /**
     * @var RecipeService
     */
    private $recipeService;

    /**
     * @var int
     */
    private $recipeItemsPerPage = 10;


    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View
     */
    public function showRecipeList()
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->userProfile;

        $recipeList = $this->recipeService->getRecipeList($profile);

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

        $recipes = $this->recipeService->getRecipeList($userProfile, $searchTerm);

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
            $savePhotos = [];

            if ($request->files->has('photos')) {
                $paramPhotos = $request->files->all();
                $savePhotos = $paramPhotos['photos'];
            }

            $photosToDeleteIds = $request->input('delete_photos');

            if (is_array($recipeFields['cooking_steps'])) {
                $recipeFields['cooking_steps'] = json_encode($recipeFields['cooking_steps']);
            }

            $recipeFields['is_published'] = $request->get('is_published') ? 1 : 0;
            $recipeFields['enable_comments'] = $request->get('enable_comments') ? 1 : 0;

            $recipe = $this->recipeService->saveRecipe($userProfile, $recipe, $recipeFields, $savePhotos);

            if ($recipe)
            {
                $this->recipeService->deletePhotos($recipe, $photosToDeleteIds);

                // Dispatch event
                RecipeCreated::dispatch($recipe);

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
