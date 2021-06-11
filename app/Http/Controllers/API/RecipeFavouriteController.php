<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Services\RecipeViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeFavouriteController extends Controller
{

    private $recipeViewService;


    public function __construct(RecipeViewService $recipeViewService)
    {
        $this->recipeViewService = $recipeViewService;
    }


    public function toggleFavourite(Request $request)
    {
        $validated = $request->validate([
            'recipe' => 'integer|exists:recipes,id',
        ]);

        $recipeId = $request->get('recipe');

        $recipe = Recipe::find($recipeId);

        $status = 400;

        $response = [
            'date_time' => now()->format('Y-m-d H:i:s')
        ];

        if (is_object($recipe) && $recipe->is_published)
        {
            $user = Auth::user();

            if ($user)
            {
                $user = Auth::user();
                $userProfile = $user->userProfile;

                $this->recipeViewService->favourite($userProfile, $recipe);

                $favourites = $recipe->recipeFavourites()->where('is_favourited', 1)->get()->count();

                $status = 200;
                $response['favourites'] = $favourites;
            }
        }

        return new JsonResponse($response, $status);
    }

}
