<?php

namespace App\Services;

use App\Models;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class RecipePhotoService extends PhotoService
{
    /**
     * @var string
     */
    protected $baseFilePath = 'recipes';

    /**
     * @var int
     */
    protected $thumbnailWidth = 150;

    /**
     * @var int
     */
    protected $thumbnailHeight = 150;

    /**
     * @var int
     */
    protected $maxFileUploads = 4;

    /**
     * @var string
     */
    const TEMP_PHOTO_SESSION_KEY = 'recipe_photos';

    /**
     * @param string $visibility
     */
    public function __construct($visibility)
    {
        parent::__construct($visibility);
    }

    /**
     * @param $imgPath
     * @throws \Exception
     */
    public function makeThumbnail($imgPath)
    {
        parent::createThumbnail($this->thumbnailWidth, $this->thumbnailHeight, $imgPath);
    }

    /**
     * @param Models\Recipe $recipe
     * @param Collection $photoIds
     * @throws \Exception
     */
    public function deletePhotos(Models\Recipe $recipe, Collection $photoIds)
    {
        $success = false;

        if ($recipe instanceof Models\Recipe && $photoIds->isEmpty() == false)
        {
            if (!is_array($photoIds)) {
                $photoIds = [$photoIds];
            }

            $recipeImgFiles = Models\File::findOrFail($photoIds);

            $recipe->files()->detach($photoIds);

            // Remove the actual files
            foreach ($recipeImgFiles as $recipeImgFile)
            {
                $this->deletePhotoFromDrive($recipeImgFile, $recipe);
            }

            $success = true;
        }

        return $success;
    }

    /**
     * @param $uuid
     * @param Collection $photoIds
     */
    public function deleteCachePhotos($uuid, Collection $photoIds)
    {
        if ($photoIds->isEmpty() == false)
        {
            $cachedPhotos = $this->getCachedPhotos($uuid);

            $files = Models\File::findOrFail($photoIds);

            // Remove the actual files
            foreach ($files as $file)
            {
                // Make sure that the files being removed are the ones in the session
                if ($cachedPhotos->contains($file->id))
                {
                    if ($file->isAttachedToRelation() === false)
                    {
                        $this->deletePhotoFromDrive($file);

                        $file->delete();
                    }
                }
            }
        }
    }

    /**
     * @param $recipeUUID
     * @param Collection $photos
     * @return array
     * @throws \Exception
     */
    public function cachePhotos($recipeUUID, Collection $photos)
    {
        $fileIds = [];

        // Get existing collection
        $cachedPhotos = $this->getCachedPhotos($recipeUUID);

        $photos->each(function($photo) use ($cachedPhotos, &$fileIds)
        {
            $savedPhoto = $this->savePhotos($photo);

            if ($savedPhoto->isNotEmpty())
            {
                $savedPhoto = $savedPhoto->first();

                $this->makeThumbnail($savedPhoto->path);


                $fileIds[] = $savedPhoto->id;

                // Add the file ID to the session cache
                $cachedPhotos->add($savedPhoto->id);
            }
        });

        $this->storeCachedPhotos($recipeUUID, $cachedPhotos);

        return $fileIds;
    }



    /**
     * @param Recipe $recipe
     * @param Collection $photos
     * @return array
     * @throws \Exception
     */
    public function saveRecipePhotos(Recipe $recipe, Collection $photos)
    {
        $fileIds = [];

        if ($recipe->files->count() < $this->getMaxFileUploads())
        {
            $savedPhotos = $this->savePhotos($photos);

            if ($savedPhotos->isNotEmpty())
            {
                $savedPhotos->each(function($photo)
                {
                    $this->makeThumbnail($photo->path);
                });

                $recipe->files()->attach($savedPhotos);

                $fileIds = $savedPhotos->map(function($file){
                    return $file->id;
                });
            }
        }

        return $fileIds;
    }

    /**
     * @param Recipe $recipe
     * @param $photoIds
     * @return bool
     * @throws \Exception
     */
    public function deleteRecipePhotos(Recipe $recipe, Collection $photoIds)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $recipePhotos */
        $recipePhotos = $recipe->files;

        $photoIds->each(function($val, $index) use ($recipePhotos, $photoIds)
        {
            // Check if the recipe has this file ID
            if ($recipePhotos->containsStrict('id', (int) $val) === false){
                unset($photoIds[$index]);
            }
        });

        return $this->deletePhotos($recipe, $photoIds);
    }

    /**
     * @param $uuid
     * @return \Illuminate\Session\Store|Collection
     */
    public function getCachedPhotos($uuid)
    {
        $photos = session(self::TEMP_PHOTO_SESSION_KEY . '.' . $uuid);
        if(empty($photos)) {
            $photos = collect();
        }
        return $photos;
    }

    /**
     * @param $uuid
     * @param Collection $photos
     */
    public function storeCachedPhotos($uuid, Collection $photos)
    {
        session([
            self::TEMP_PHOTO_SESSION_KEY => [$uuid => $photos]
        ]);
    }

    /**
     * @return int
     */
    public function getMaxFileUploads()
    {
        return $this->maxFileUploads;
    }
}
