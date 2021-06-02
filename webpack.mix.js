const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

/**
 * JS mix
 */
mix
    .autoload({
        jquery: ['$', 'jQuery'],
        bootstrap: ['bootstrap'],
        Cropper: ['Cropper'],
    })
    .extract([
        'jquery',
        'Tagify',
        'Cropper'
    ])
    .js('resources/js/app.js', 'public/js')
    .combine([
        'resources/js/theme/plugins.js',
        'resources/js/theme/main.js',
        'resources/js/theme/profile_pic.js',
    ], 'public/js/theme.js')
    .combine('resources/js/recipe/*.js', 'public/js/recipe.js')
    .version()
;

mix
    .postCss('resources/css/app.css', 'public/css')
    .version()
;
