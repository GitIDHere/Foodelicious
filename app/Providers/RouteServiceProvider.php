<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';



    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function ()
        {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));


            /**
             * Load in all the separate route files
             */
//            $routeFiles = File::allFiles(base_path('routes/paths'));
//
//            foreach ($routeFiles as $routeFile)
//            {
//                Route::middleware('web')
//                    ->namespace($this->namespace)
//                    ->group($routeFile->getPathname());
//            }


            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/auth/email_verification.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/auth/login.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/auth/password_reset.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/auth/register.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/user/profile.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/user/security.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/user/user_recipes.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/user/recipe_favourites.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paths/web/recipes.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
