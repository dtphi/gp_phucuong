<?php

use Illuminate\Support\Facades\Route;
use App\AppGlobals\CSS;

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

Route::view('/admin', 'administrator', ['css' => new CSS()]);

Route::view('/admin/{any}', 'administrator', ['css' => new CSS()])->where('any', '.*');
