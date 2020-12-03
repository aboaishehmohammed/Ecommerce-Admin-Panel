const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/categories.js', 'public/js/adminApp')
    .js('resources/js/sub-categories.js', 'public/js/adminApp')
    .js('resources/js/products.js', 'public/js/adminApp')
    .js('resources/js/bills.js', 'public/js/adminApp')
    .js('resources/js/reports.js', 'public/js/adminApp')

    .sass('resources/sass/app.scss', 'public/css');
