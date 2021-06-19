<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeCommentRequest;
use App\Models\AppLog;
use App\Models\Recipe;
use App\Services\RecipeViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteComment(Request $request)
    {
        $validated = $request->validate([
            'recipe' => 'integer|exists:recipes,id',
            'comment' => 'integer|exists:recipe_comments,id',
        ]);

        try
        {
            $status = 500;

            $recipeId = $request->get('recipe');
            $commentId = $request->get('comment');

            $user = Auth::user();
            $userProfile = $user->userProfile;

            $recipe = Recipe::find($recipeId);

            $isDeleted = $this->recipeViewService->deleteComment($userProfile, $recipe, $commentId);

            if ($isDeleted) {
                $status = 204;
                $request->session()->flash('comment-toast', 'Comment successfully deleted');
            }

        } catch (\Exception $exception) {
            AppLog::createLog($request, AppLog::TYPE_EXCEPTION, $exception);
        }

        return new JsonResponse(null, $status);
    }

    /**
     * @param RecipeCommentRequest $request
     * @return JsonResponse
     */
    public function saveComment(RecipeCommentRequest $request)
    {
        try
        {
            $status = 500;
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
                $request->session()->flash('comment-toast', 'Comment successfully posted');
            }
        }
        catch (\Exception $exception) {
            $response['message'] = 'Error processing request';
        }

        return new JsonResponse($response, $status);
    }

}
