<?php

namespace App\Providers;

use Barryvdh\Elfinder\ElfinderServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        if ((int)request()->input('lmId') > 0) {
            $this->app['config']->set('elfinder.dir', 'HoSo/' . request()->input('lmId'));
        }

        $viewPath = __DIR__ . '/../resources/views/vendor/elfinder';
        $this->loadViewsFrom($viewPath, 'elfinder');
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/elfinder'),
        ], 'views');

        if (!defined('ELFINDER_IMG_PARENT_URL')) {
            define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('packages/barryvdh/elfinder'));
        }

        $config = $this->app['config']->get('elfinder.route', []);
        $config['namespace'] = 'Barryvdh\Elfinder';

        $router->group($config, function ($router) {
            $router->get('/news',  ['as' => 'elfinder.index', 'uses' => 'ElfinderController@showIndex']);
            $router->any('connector', ['as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector']);
            $router->get('popup/{input_id}', ['as' => 'elfinder.popup', 'uses' => 'ElfinderController@showPopup']);
            $router->get('filepicker/{input_id}', ['as' => 'elfinder.filepicker', 'uses' => 'ElfinderController@showFilePicker']);
            $router->get('tinymce', ['as' => 'elfinder.tinymce', 'uses' => 'ElfinderController@showTinyMCE']);
            $router->get('tinymce4', ['as' => 'elfinder.tinymce4', 'uses' => 'ElfinderController@showTinyMCE4']);
            $router->get('tinymce5', ['as' => 'elfinder.tinymce5', 'uses' => 'ElfinderController@showTinyMCE5']);
            $router->get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'ElfinderController@showCKeditor4']);
        });
    }
}
