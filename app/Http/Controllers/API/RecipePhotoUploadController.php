<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\RecipePhotoService;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class RecipePhotoUploadController extends Controller
{
    /**
     * @var RecipePhotoService
     */
    private $recipePhotoService;


    public function __construct(RecipePhotoService $recipePhotoService)
    {
        $this->recipePhotoService = $recipePhotoService;
    }

    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return JsonResponse
     */
    public function getRecipePhotos(Request $request, Recipe $recipe)
    {
        $photoData = $recipe->files->map(function($photo)
        {
            $photoInfo = [
                'id' => $photo->id,
                'filename' => $photo->name,
                'path' => asset($photo->public_path),
                'thumbnail_path' => asset($photo->thumbnail_path)
            ];

            try {
                $photoInfo['size'] = filesize($photo->public_path);
            }
            catch (\Exception $exception) {
                $photoInfo['size'] = 0;
            }

            return $photoInfo;
        });

        return new JsonResponse($photoData, 200);
    }

    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return JsonResponse
     * @throws \Exception
     */
    public function deletePhotos(Request $request, Recipe $recipe)
    {
        $photoId = $request->get('id');
        $success = $this->recipePhotoService->deletePhotos($recipe, collect($photoId));

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

        $savePhotos = collect();

        if ($request->files->has('photos')) {
            $savePhotos = collect($request->files->all());
        }

        $savedFiles = $this->recipePhotoService->saveRecipePhotos($recipe, $savePhotos);

        $status = (!empty($savedFiles)) ? 201 : 500;

        return new JsonResponse($savedFiles, $status);
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function cachePhotos(Request $request, $uuid)
    {
        $validated = $request->validate([
            'photos' => 'nullable',
            'photos.*' => 'mimes:jpeg,jpg,png|max:6144',
        ]);

       $photos = collect();

        if ($request->files->has('photos'))
        {
            $paramPhotos = $request->files->all();
            $photos->add($paramPhotos['photos']);
        }

        $fileIds = $this->recipePhotoService->cachePhotos($uuid, $photos);

        return new JsonResponse($fileIds, 201);
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return JsonResponse
     */
    public function deleteCachedPhoto(Request $request, $uuid)
    {
        $photoId = $request->get('id');
        $this->recipePhotoService->deleteCachePhotos($uuid, collect($photoId));
        return new JsonResponse(null, 204);
    }
}
