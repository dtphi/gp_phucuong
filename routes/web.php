<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('front.')
    ->group(function () {
        Route::get('/', 'Controller@front')->name('front.dashboard');
    });

Route::name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'Controller@admin')->name('admin.dashboard');
    });
