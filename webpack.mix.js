const mix = require('laravel-mix');
require('laravel-mix-alias');

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
mix.alias('@app', '/resources/js');
mix.alias('com@front', '/resources/js/components/front');
mix.alias('store@front', '/resources/js/stores/front');
mix.alias('v@front', '/resources/js/views/front');
mix.alias('com@admin', '/resources/js/components/admin');
mix.alias('store@admin', '/resources/js/stores/admin');
mix.alias('v@admin', '/resources/js/views/admin');
mix.alias('api@admin', '/resources/js/api/admin');
mix.js('resources/js/app-admin.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
mix.js('resources/js/app-front.js', 'public/js');