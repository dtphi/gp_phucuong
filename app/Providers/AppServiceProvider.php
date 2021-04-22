<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @author : dtphi.
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*======================Admin============================.*/
        Sanctum::ignoreMigrations();
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\AdminModel::class,
            \App\Http\Controllers\Api\Admin\Services\AdminService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\InformationModel::class,
            \App\Http\Controllers\Api\Admin\Services\InformationService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\NewsGroupModel::class,
            \App\Http\Controllers\Api\Admin\Services\NewsGroupService::class
        );

        /*=====================Front end======================== .*/
        $this->app->bind(
            \App\Http\Controllers\Api\Front\Services\Contracts\BaseModel::class,
            \App\Http\Controllers\Api\Front\Services\Service::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Front\Services\Contracts\HomeModel::class,
            \App\Http\Controllers\Api\Front\Services\HomeService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Front\Services\Contracts\NewsModel::class,
            \App\Http\Controllers\Api\Front\Services\NewsService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Front\Services\Contracts\VideoModel::class,
            \App\Http\Controllers\Api\Front\Services\VideoService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*$scheme = config('app.force_scheme') ?? 'https';
        if (empty($scheme)) {
            $scheme = 'https';
        }
        URL::forceScheme($scheme);*/

        /*use when auth bear token, create client_access_tokens table*/
        //Sanctum::usePersonalAccessTokenModel(ClientAccessToken::class);
    }
}
