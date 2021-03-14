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
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
