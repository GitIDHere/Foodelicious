<?php

namespace App\Services;

use Illuminate\Database\Eloquent;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use App\Models\File as AppFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    /**
     * @var array
     */
    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
    ];

    /**
     * Max file size in MB
     * @var int
     */
    protected $maxFileSizeMb = 1;

    /**
     * @var string
     */
    protected $baseFilePath = '';

    /**
     * @var null|FilesystemAdapter
     */
    protected $drive = null;

    /**
     * @var string
     */
    private $thumbnailPath = 'thumbnails';

    /**
     * @var string
     */
    private $tmpPath = 'img_tmp';

    /**
     * @var string
     */
    private $visibility = self::VISIBILITY_PRIVATE;

    /**
     * @const string
     */
    const VISIBILITY_PRIVATE = 'private';

    /**
     * @const string
     */
    const VISIBILITY_PUBLIC = 'public';


    /**
     * @param string $visibility
     */
    public function __construct($visibility)
    {
        $this->visibility = $visibility;
        $this->drive = Storage::drive();
    }


    /**
     * @param $files
     * @param array $customNames
     * @return Eloquent\Collection
     */
    public function savePhotos(Collection $files, $customNames = [])
    {
        $savedFiles = new Eloquent\Collection();

        $visibility = $this->getVisibility();

        foreach($files as $fileIndex => $file)
        {
            // Check that the mime type is allowed
            if (in_array($file->getMimeType(), $this->allowedMimeTypes))
            {
                // Check that the size is in limit
                $fileSizeBytes = $file->getSize();
                $fileSizeMb = $this->getMbFromBytes($fileSizeBytes);

                if ($fileSizeMb > 0 && $fileSizeMb <= $this->maxFileSizeMb)
                {
                    // Check if the file needs custom name
                     if (isset($customNames[$fileIndex]) && !empty($customNames[$fileIndex]))
                     {
                         $fileName = $customNames[$fileIndex];
                         $path = $this->drive->putFileAs($visibility . '/' . $this->baseFilePath, new File($file->getPathname()), $fileName);
                     }
                     else {
                         $path = $this->drive->putFile($visibility . '/' . $this->baseFilePath, new File($file->getPathname()));
                     }

                     if ($path)
                     {
                        $fileName = basename($path);

                        $savedFiles->add(AppFile::create([
                             'name' => $fileName,
                             'path' => $this->baseFilePath . '/' . $fileName
                         ]));
                     }
                }
            }
        }

        return $savedFiles;
    }


    /**
     * @param int width
     * @param int height
     * @param $imgPath
     * @throws \Exception
     */
    public function createThumbnail($width, $height, $imgPath)
    {
        $visibility = $this->getVisibility();
        $thumbnailDirPath = $visibility . '/' . $this->thumbnailPath . '/' . $this->baseFilePath;

        $thumbnailDir = $this->drive->path($thumbnailDirPath);

        $this->createDir($thumbnailDir);

        createImage($thumbnailDir, $this->drive->path($visibility . '/' . $imgPath), $width, $height);
    }

    /**
     * Ref: https://stackoverflow.com/a/11376379/5486928
     *
     * @param $basePath
     * @param $imgPath
     * @param $targetWidth
     * @param $targetHeight
     * @param $cropWidth
     * @param $cropHeight
     * @param int $cropX
     * @param int $cropY
     * @return string|null
     * @throws \Exception
     */
    public function cropPhoto($basePath, $imgPath, $targetWidth, $targetHeight, $cropWidth, $cropHeight, $cropX = 0, $cropY = 0)
    {
        $arr_image_details = getimagesize($imgPath);
        $imgName = basename($imgPath);

        $imgDir = $this->visibility . '/' . $basePath;

        $this->createDir($imgDir);

        $fullFilePath = $this->drive->path($imgDir);

        if ($arr_image_details[2] == IMAGETYPE_JPEG) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        }
        if ($arr_image_details[2] == IMAGETYPE_PNG) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        }

        if ($targetWidth > $targetHeight) {
            $new_width = $targetWidth;
            $new_height = intval($targetHeight * $new_width / $targetWidth);
        } else {
            $new_height = $targetHeight;
            $new_width = intval($targetWidth * $new_height / $targetHeight);
        }

        if ($imgt)
        {
            $old_image = $imgcreatefrom($imgPath);

            // Crop the original image
            $croppedImg = imagecrop($old_image, ['x' => $cropX, 'y' => $cropY, 'width' => $cropWidth, 'height' => $cropHeight]);

            // Create a blank img canvas for the cropped image to be placed onto
            $targetImageCanvas = imagecreatetruecolor($targetWidth, $targetHeight);

            // White background
            $white  = imagecolorallocate($targetImageCanvas,255,255,255);
            imagefilledrectangle($targetImageCanvas,0,0,$targetWidth-1,$targetHeight-1, $white);

            // Fit the cropped image onto the target canvas
            imagecopyresized($targetImageCanvas, $croppedImg, 0, 0, 0, 0, $new_width, $new_height, $cropWidth, $cropHeight);

            $imgRes = $imgt($targetImageCanvas, $fullFilePath . '/' . $imgName);

            if ($imgRes) {
                return $basePath . '/' . $imgName;
            }
        }

        return null;
    }

    /**
     * @param FilesystemAdapter $drive
     */
    public function setDrive($drive)
    {
        $this->drive = $drive;
    }

    /**
     * @return string
     */
    public function getTempPath()
    {
        return $this->visibility . '/' . $this->tmpPath;
    }

    /**
     * @param $fullPath
     * @param int $perms
     * @param bool $recursive
     */
    private function createDir($fullPath, $perms = 755, $recursive = true)
    {
        if (!$this->drive->exists($fullPath))
        {
            \Illuminate\Support\Facades\File::ensureDirectoryExists($fullPath, $perms, $recursive);
        }
    }

    /**
     * @param $bytes
     * @return float
     */
    private function getMbFromBytes($bytes)
    {
        return $bytes * 0.000000954;
    }

    /**
     * @param string $baseFilePath
     */
    public function setBaseFilePath($baseFilePath)
    {
        $this->baseFilePath = $baseFilePath;
    }

    /**
     * @param $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param Eloquent\Model $model
     * @param AppFile $picFile
     */
    public function deletePhotoFromDrive(\App\Models\File $picFile, Eloquent\Model $model = null)
    {
        if ($model instanceof Eloquent\Model)
        {
            // Remove the table link
            $model->files()->detach($picFile->id);

            $picFile->is_attached = 0;
            $picFile->save();
        }

        $public = self::VISIBILITY_PUBLIC;

        // Delete the file from the directory
        $this->drive->delete($public . '/' . $picFile->path);

        // Delete thumbnails
        $this->drive->delete($public . '/thumbnails/' . $picFile->path);
    }

}
