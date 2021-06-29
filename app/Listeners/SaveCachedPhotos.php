<?php

namespace App\Listeners;

use App\Events\RecipeCreated;
use App\Models\AppLog;
use App\Models\File;
use App\Services\RecipePhotoService;

class SaveCachedPhotos
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
     * Handle the event.
     * @return void
     */
    public function handle(RecipeCreated $event)
    {
        $uuid = $event->getUUID();
        $recipe = $event->getRecipe();

        try {
            $cachedPhotoIDs = $this->recipePhotoService->getCachedPhotos($uuid);

            $photos = File::find($cachedPhotoIDs);

            // Attach the photos to the recipe
            $photos->each(function($photo) use ($recipe)
            {
                $recipe->files()->attach($photo);
                $photo->update(['is_attached' => true]);
            });
        }
        catch (\Exception $exception) {
            AppLog::createLog(AppLog::TYPE_EXCEPTION, $exception);
        }
    }
}
