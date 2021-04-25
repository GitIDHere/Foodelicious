<?php

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

if (! function_exists('isDev'))
{
    function isDev()
    {
        $env = strtolower(env('APP_ENV'));
        return ($env == 'dev' || $env == 'local');
    }
}

if (! function_exists('randUsername'))
{
    function randUsername()
    {
        $username = '';
        if (isDev()) {
            $username = 'user'.rand(0, 999);
        }
        return $username;
    }
}

if (! function_exists('randEmail'))
{
    function randEmail()
    {
        $email = '';
        if (isDev()) {
            $email = 'user'.rand(0, 999).'@gmail.com';
        }
        return $email;
    }
}

if (! function_exists('collectionPaginate'))
{
    /**
     * Ref: https://sam-ngu.medium.com/laravel-how-to-paginate-collection-8cb4b281bc55
     *
     * @param Collection $results
     * @param $pageSize
     * @return mixed
     */
    function collectionPaginate(Collection $results, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }
}

if (! function_exists('paginator'))
{
    function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(\App\Classes\CustomPaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}

if (! function_exists('cropImage'))
{
    /**
     * Ref: https://stackoverflow.com/a/11376379/5486928
     *
     * @param $fileDir
     * @param $imgPath
     * @param int $targetWidth
     * @param int $targetHeight
     * @param int $cropWidth
     * @param int $cropHeight
     * @param null|int $cropX
     * @param null|int $cropY
     * @return null|string
     */
    function cropImage($fileDir, $imgPath, $targetWidth, $targetHeight, $cropWidth, $cropHeight, $cropX = 0, $cropY = 0)
    {
        $arr_image_details = getimagesize($imgPath);
        $imgName = basename($imgPath);

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

            $imgRes = $imgt($targetImageCanvas, $fileDir . $imgName);
            if ($imgRes) {
                return $fileDir . $imgName;
            }
        }

        return null;
    }
}



if (! function_exists('createImage'))
{
    /**
     * Ref: https://stackoverflow.com/a/11376379/5486928
     *
     * @param string $ImgDirectory
     * @param string $imgPath
     * @param int $targetWidth
     * @param int $targetHeight
     */
    function createImage($ImgDirectory, $imgPath, $targetWidth, $targetHeight)
    {
        $arr_image_details = getimagesize($imgPath);
        $imgName = basename($imgPath);

        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];

        if ($original_width > $original_height) {
            $new_width = $targetWidth;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $targetHeight;
            $new_width = intval($original_width * $new_height / $original_height);
        }

        $dest_x = intval(($targetWidth - $new_width) / 2);
        $dest_y = intval(($targetHeight - $new_height) / 2);

        if ($arr_image_details[2] == IMAGETYPE_JPEG) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        }
        if ($arr_image_details[2] == IMAGETYPE_PNG) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        }

        if ($imgt) {
            $old_image = $imgcreatefrom($imgPath);
            $new_image = imagecreatetruecolor($targetWidth, $targetHeight);

            $white  = imagecolorallocate($new_image,255,255,255);
            imagefilledrectangle($new_image,0,0,$targetWidth-1,$targetHeight-1, $white);

            imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $imgt($new_image, $ImgDirectory . $imgName );
        }
    }
}
