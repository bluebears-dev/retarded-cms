let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/dashboard.js', 'public/js')
    .js('resources/assets/js/app/bootstrap.js', 'public/js')
    .js('resources/assets/js/login.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/rcms/default/login.scss', 'public/css/default')
    .sass('resources/assets/sass/rcms/default/dashboard.scss', 'public/css/default')
    .sass('resources/assets/sass/rcms/frozen/login.scss', 'public/css/frozen')
    .sass('resources/assets/sass/rcms/frozen/dashboard.scss', 'public/css/frozen');
mix.browserSync({proxy: 'localhost:80'});