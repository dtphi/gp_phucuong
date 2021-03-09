<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
