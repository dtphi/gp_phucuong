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
   .sass('resources/sass/app.scss', 'public/css');
//    .extract([
//        '@babel/polyfill',
//        '@popperjs/core',
//        'axios',
//        'axios-auth-refresh',
//        'bootstrap',
//        'bootstrap-vue',
//        'jquery',
//        'lodash',
//        'moment',
//        'popper.js',
//        'vee-validate',
//        'vue',
//        'vue-axios',
//        'vue-router',
//        'vuex',
//        'vuex-persistedstate'
//    ]);
