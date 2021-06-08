<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\RecipeRatingService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeRatingsController extends Controller
{

    private $recipeRatingService;

    public function __construct(RecipeRatingService $recipeRatingService)
    {
        $this->recipeRatingService = $recipeRatingService;
    }


    public function toggleRating(Request $request)
    {
        $validated = $request->validate([
            'recipe' => 'integer|exists:recipes,id',
        ]);

        $recipeId = $request->get('recipe');
        $recipe = Recipe::where('id', $recipeId)->first();

        $response = [
            'status' => 404,
            'date_time' => now()->format('Y-m-d H:i:s')
        ];

        if (is_object($recipe) && $recipe->is_published)
        {
            $user = Auth::user();

            if ($user)
            {
                $user = Auth::user();
                $userProfile = $user->userProfile;

                $this->recipeRatingService->toggleRating($userProfile, $recipe);

                $ratings = $recipe->loadCount('recipeRatings')->recipe_ratings_count;

                $response['status'] = 200;
                $response['ratings'] = $ratings;
            }
        }

        return new JsonResponse($response);
    }














}
