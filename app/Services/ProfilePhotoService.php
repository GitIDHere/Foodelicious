<?php namespace App\Services;

use App\Models\UserProfile;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class ProfilePhotoService extends PhotoService
{
    /**
     * @var string
     */
    protected $baseFilePath = 'profile_pics';

    /**
     * @var int
     */
    protected $target_width = 500;

    /**
     * @var int
     */
    protected $target_height = 500;


    /**
     * ProfilePhotoService constructor.
     * @param $visibility
     */
    public function __construct($visibility)
    {
        parent::__construct($visibility);
    }

    /**
     * @param UploadedFile $img
     * @param $cropWidth
     * @param $cropHeight
     * @param $cropX
     * @param $cropY
     * @return string|null
     */
    public function crop(UploadedFile $img, $cropWidth, $cropHeight, $cropX, $cropY)
    {
        $imgPath = $this->saveTempImage($img);

        $imagePath = '';

        if ($imgPath) {
            // Crop the uploaded image
            $imagePath = $this->cropPhoto($this->baseFilePath, $this->drive->path($imgPath), $this->target_width, $this->target_height, $cropWidth, $cropHeight, $cropX, $cropY);
        }

        return $imagePath;
    }

    /**
     * @param UserProfile $userProfile
     * @param \App\Models\File $picFile
     */
//    public function removePic(UserProfile $userProfile, \App\Models\File $picFile)
//    {
//        if ($userProfile instanceof UserProfile)
//        {
//            $public = self::VISIBILITY_PUBLIC;
//
//            // Remove the table link
//            $userProfile->files()->detach($picFile->id);
//
//            // Delete the file from the directory
//            $this->drive->delete($public . '/' . $picFile->path);
//        }
//    }

    /**
     * @param UploadedFile $image
     * @return false|string
     */
    private function saveTempImage($image)
    {
        $originalVisibility = $this->getVisibility();

        // Set the visibility to private because we are storing it in temp folder
        $this->setVisibility(self::VISIBILITY_PRIVATE);

        // Put the uploaded image in a temp folder so that we have it saved somewhere on the server
        $imgPath = $this->drive->putFile($this->getTempPath(), new File($image->getPathname()));

        $this->setVisibility($originalVisibility);

        return $imgPath;
    }

    /**
     * @param int $width
     */
    public function setTargetWidth($width)
    {
        $this->target_width = $width;
    }

    /**
     * @param int $height
     */
    public function setTargetHeight($height)
    {
        $this->target_height = $height;
    }

}
