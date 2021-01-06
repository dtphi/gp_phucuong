<?php

namespace App\Providers;

use App\Http\LcgServices\LcgContracts\LcgNewsContract;
use App\Http\LcgServices\LcgContracts\LcgNewsGroupContract;
use App\Http\LcgServices\LcgContracts\LcgUserContract;
use App\Http\LcgServices\LcgNewsGroupService;
use App\Http\LcgServices\LcgNewsService;
use App\Http\LcgServices\LcgUserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @author : Phi .
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LcgUserContract::class,LcgUserService::class);
        $this->app->singleton(LcgNewsGroupContract::class, LcgNewsGroupService::class);
        $this->app->singleton(LcgNewsContract::class, LcgNewsService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
