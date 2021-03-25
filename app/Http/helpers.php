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

if (! function_exists('createThumbnail')) 
{
    /**
     * Ref: https://stackoverflow.com/a/11376379/5486928
     *
     * @param $thumbDir
     * @param $imgPath
     */
    function createThumbnail($thumbDir, $imgPath)
    {
        $thumbnail_width = 150;
        $thumbnail_height = 150;
        
        $arr_image_details = getimagesize($imgPath); // pass id to thumb name
        $imgName = basename($imgPath);
        
        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];
        
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $thumbnail_height;
            $new_width = intval($original_width * $new_height / $original_height);
        }
        
        $dest_x = intval(($thumbnail_width - $new_width) / 2);
        $dest_y = intval(($thumbnail_height - $new_height) / 2);
        
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
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            
            $white  = imagecolorallocate($new_image,255,255,255);
            imagefilledrectangle($new_image,0,0,$thumbnail_width-1,$thumbnail_height-1,$white);
            
            imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $imgt($new_image, $thumbDir . $imgName );
        }
    }
}
