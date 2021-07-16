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
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\SettingModel::class,
            \App\Http\Controllers\Api\Admin\Services\SettingService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucModel::class,
            \App\Http\Controllers\Api\Admin\Services\LinhMucService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\GiaoPhanModel::class,
            \App\Http\Controllers\Api\Admin\Services\GiaoPhanService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\GiaoHatModel::class,
            \App\Http\Controllers\Api\Admin\Services\GiaoHatService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\GiaoXuModel::class,
            \App\Http\Controllers\Api\Admin\Services\GiaoXuService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\GiaoDiemModel::class,
            \App\Http\Controllers\Api\Admin\Services\GiaoDiemService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\CongDoanTuSiModel::class,
            \App\Http\Controllers\Api\Admin\Services\CongDoanTuSiService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\DongModel::class,
            \App\Http\Controllers\Api\Admin\Services\DongService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\CoSoModel::class,
            \App\Http\Controllers\Api\Admin\Services\CoSoService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\ThanhModel::class,
            \App\Http\Controllers\Api\Admin\Services\ThanhService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\ChucVuModel::class,
            \App\Http\Controllers\Api\Admin\Services\ChucVuService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\LeChinhModel::class,
            \App\Http\Controllers\Api\Admin\Services\LeChinhService::class
        );
        $this->app->bind(
            \App\Http\Controllers\Api\Admin\Services\Contracts\LinhMucBangCapModel::class,
            \App\Http\Controllers\Api\Admin\Services\LinhMucBangCapService::class
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
        $this->app->bind(
            \App\Http\Controllers\Api\Front\Services\Contracts\SettingModel::class,
            \App\Http\Controllers\Api\Front\Services\SettingService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $scheme = (config('app.force_https')=='http')?'http':'https';
        URL::forceScheme($scheme);

        /*use when auth bear token, create client_access_tokens table*/
        //Sanctum::usePersonalAccessTokenModel(ClientAccessToken::class);
    }
}
