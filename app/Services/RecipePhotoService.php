<?php

namespace App\Services;

use App\Models;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;

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

            $recipe->files()->detach($photoIds);

            $recipeImgFiles = Models\File::find($photoIds)->all();

            // Remove the actual files
            foreach ($recipeImgFiles as $recipeImgFile)
            {
                $this->deletePhotoFromDrive($recipe, $recipeImgFile);
            }

            $success = true;
        }

        return $success;
    }

    /**
     * @return int
     */
    public function getMaxFileUploads()
    {
        return $this->maxFileUploads;
    }
}
