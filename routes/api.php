<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/test', function (Request $request) {
            return ['test' => 'ok'];die;
        });

Route::namespace('App\Http\Controllers\Api\Front')
    ->middleware('web')
    ->group(function () {
        Route::any('/app/get-setting', 'Base\ApiController@getSetting');
        Route::apiResource('/homes/get-list', 'HomeController');
        Route::get('/app/info/get-information-list','NewsController@list');
        Route::get('/app/info/get-information','NewsController@detail');
        Route::get('/app/info/get-latest-information', 'NewsController@showLastedList');
        Route::get('/app/info/get-popular-information', 'NewsController@showPopularList');
        Route::get('/app/info/get-related-information', 'NewsController@showRelatedList');
        Route::get('/app/info/get-special-information', 'NewsController@showSpecialModuleList');
        Route::get('/app/get-data-module', 'ModuleController@showDataList');
    });

Route::namespace('App\Http\Controllers\Api\Admin')
    ->middleware('web')
    ->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
	});

Route::namespace('App\Http\Controllers\Api\Admin')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/user', function (Request $request) {
            $user = $request->user();
            $user->isAdmin = fn_is_admin_permission();
            return $request->user();
        });

        Route::apiResource('users', 'AdminController');
        Route::get('/search-user','AdminController@search');
        Route::apiResource('news-groups', 'NewsGroupController');
        Route::get('/news-categories/dropdowns','NewsGroupController@dropdown');
        Route::apiResource('news', 'InformationController');
        Route::get('/informations/dropdowns','InformationController@dropdown');
        Route::apiResource('settings', 'SettingController');

        Route::apiResource('linh-mucs', 'LinhMucController');
        Route::apiResource('linh-muc-bang-caps', 'LinhMucBangCapController');
        Route::apiResource('linh-muc-chuc-thanhs', 'LinhMucChucThanhController');
        Route::apiResource('linh-muc-van-thus', 'LinhMucVanThuController');
        Route::apiResource('linh-muc-thuyen-chuyens', 'LinhMucThuyenChuyenController');

        Route::apiResource('giao-phans', 'GiaoPhanController');
        Route::apiResource('giao-hats', 'GiaoHatController');
        Route::apiResource('giao-xus', 'GiaoXuController');
        Route::apiResource('giao-diems', 'GiaoDiemController');
        Route::apiResource('cong-doan-tu-sis', 'CongDoanTuSiController');
        Route::apiResource('co-sos', 'CoSoController');
        Route::apiResource('dongs', 'DongController');
        Route::apiResource('thanhs', 'ThanhController');
        Route::apiResource('chuc-vus', 'ChucVuController');
        Route::apiResource('le-chinhs', 'LeChinhController');

        Route::any('/mmedia/{any}', function () {});
    });
