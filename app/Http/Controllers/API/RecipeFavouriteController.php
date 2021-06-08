<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeFavouriteService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeFavouriteController extends Controller
{

    private $recipeFavouriteService;

    public function __construct(RecipeFavouriteService $recipeFavouriteService)
    {
        $this->recipeFavouriteService = $recipeFavouriteService;
    }


    public function toggleFavourite(Request $request)
    {
        $validated = $request->validate([
            'recipe' => 'integer|exists:recipes,id',
        ]);

        $recipeId = $request->get('recipe');
        $recipe = Recipe::where('id', $recipeId)->first();

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

                $this->recipeFavouriteService->favourite($userProfile, $recipe);

                $favourites = $recipe->recipeFavourites()->where('is_favourited', 1)->get()->count();

                $status = 200;
                $response['favourites'] = $favourites;
            }
        }

        return new JsonResponse($response, $status);
    }














}
