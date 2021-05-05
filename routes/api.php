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
            return $request->user();
        });

        Route::apiResource('users', 'AdminController');
        Route::get('/search-user','AdminController@search');
        Route::apiResource('news-groups', 'NewsGroupController');
        Route::get('/news-categories/dropdowns','NewsGroupController@dropdown');
        Route::apiResource('news', 'InformationController');
        Route::get('/informations/dropdowns','InformationController@dropdown');
        Route::apiResource('settings', 'SettingController');

        Route::any('/mmedia/{any}', function () {});
    });
