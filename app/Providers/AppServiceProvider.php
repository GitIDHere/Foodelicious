<?php

namespace App\Providers;

use App\Classes\APIResponse;
use App\Services\PhotoService;
use App\Services\ProfilePhotoService;
use App\Services\RecipePhotoService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(APIResponse::class, function($app){
            return new APIResponse();
        });
    
        $this->app->bind(ProfilePhotoService::class, function ($app) {
            $driver = Storage::drive(PhotoService::VISIBILITY_PUBLIC);
            return new ProfilePhotoService($driver);
        });
    
        $this->app->bind(RecipePhotoService::class, function ($app) {
            $driver = Storage::drive(PhotoService::VISIBILITY_PUBLIC);
            return new RecipePhotoService($driver);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
