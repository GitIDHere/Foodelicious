<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RecipePhotoUploadController extends Controller
{
    /**
     * @var RecipeService
     */
    private $recipeService;


    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }


    public function deletePhotos(Request $request, Recipe $recipe)
    {
        /**
         * - Make sure that the IDs actually represent the recipe
         * - Make sure the recipe belongs to the user
         */

        $photoId = $request->get('id');
        $success = $this->recipeService->deletePhotos($recipe, collect($photoId));

        $status = ($success ? 204 : 500);

        return new JsonResponse(null, $status);
    }


    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return JsonResponse
     * @throws \Exception
     */
    public function savePhotos(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'photos' => 'nullable',
            'photos.*' => 'mimes:jpeg,jpg,png|max:6144',
        ]);

        $savePhotos = [];

        if ($request->files->has('photos')) {
            $paramPhotos = $request->files->all();
            $savePhotos = $paramPhotos['photos'];
        }

        $savedFiles = $this->recipeService->savePhotos($recipe, $savePhotos);

        $status = (!empty($savedFiles)) ? 201 : 500;

        return new JsonResponse($savedFiles, $status);
    }

}
