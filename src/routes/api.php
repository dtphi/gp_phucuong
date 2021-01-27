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
    });

