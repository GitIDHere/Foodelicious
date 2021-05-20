<?php

namespace App\Providers;

use App\Classes\AppResponse;
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
        $this->app->bind(AppResponse::class, function($app){
            return new AppResponse();
        });

        $this->app->bind(ProfilePhotoService::class, function ($app) {
            return new ProfilePhotoService(PhotoService::VISIBILITY_PUBLIC);
        });

        $this->app->bind(RecipePhotoService::class, function ($app) {
            return new RecipePhotoService(PhotoService::VISIBILITY_PUBLIC);
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
