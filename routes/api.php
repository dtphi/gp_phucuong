<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::namespace('Api')
    ->middleware('web')
    ->group(function () {
        Route::post('login', 'LcgAuthController@login');
        Route::post('logout', 'LcgAuthController@logout');
    });

Route::namespace('Api')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', 'LcgUserController');
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('news-groups', 'LcgNewsGroupController');
    });
