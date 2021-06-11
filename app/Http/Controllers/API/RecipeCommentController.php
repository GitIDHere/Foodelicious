<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeCommentRequest;
use App\Models\Recipe;
use App\Services\RecipeViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeCommentController extends Controller
{
    /**
     * @var RecipeViewService
     */
    private $recipeViewService;


    public function __construct(RecipeViewService $recipeViewService)
    {
        $this->recipeViewService = $recipeViewService;
    }

    /**
     * @param RecipeCommentRequest $request
     * @return JsonResponse
     */
    public function saveComment(RecipeCommentRequest $request)
    {
        try
        {
            $status = 400;
            $response = [
                'date_time' => now()->format('Y-m-d H:i:s')
            ];

            $comment = $request->get('comment');
            $recipe = $request->get('recipe');

            $user = Auth::user();
            $userProfile = $user->userProfile;

            $recipe = Recipe::find($recipe);

            $isCommentSaved = $this->recipeViewService->saveComment($userProfile, $recipe, $comment);

            if ($isCommentSaved) {
                $status = 201;
            }
            else {
                $status = 409;
            }
        }
        catch (\Exception $exception) {
            $response['message'] = 'Error processing request';
        }

        return new JsonResponse($response, $status);
    }

}
