<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\RepresentativeController as AdminRepresentativeController;
use App\Http\Controllers\Api\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Api\Message\MessageController;
use App\Http\Controllers\Api\Representative\AuthController as RepresentativeAuthController;
use App\Http\Controllers\Api\Representative\SettingController as RepresentativeSettingController;
use App\Http\Controllers\Api\Store\AuthController as StoreAuthController;
use App\Http\Controllers\Api\Store\CatalogController;
use App\Http\Controllers\Api\Store\PurchaseHistoryController;
use App\Http\Controllers\Api\Store\SettingController as StoreSettingController;
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

Route::prefix('v1')->group(function() {
    Route::prefix('admin')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::post('login', [ AdminAuthController::class, 'login' ]);
            Route::get('admin', [ AdminAuthController::class, 'admin' ]);

            Route::middleware([ 'assign.guard:admins', 'jwt.auth' ])->group(function() {
                Route::get('refresh', [ AdminAuthController::class, 'refresh' ]);
                Route::post('logout', [ AdminAuthController::class, 'logout' ]);
            });
        });

        Route::middleware([ 'assign.guard:admins', 'jwt.auth' ])->group(function() {
            Route::prefix('sales-representatives')->group(function() {
                Route::get('', [ AdminRepresentativeController::class, 'index' ]);
                Route::post('create', [ AdminRepresentativeController::class, 'create' ]);
                Route::get('check-deleted/{id}', [ AdminRepresentativeController::class, 'checkDeleted' ]);
                Route::post('check-validated', [ AdminRepresentativeController::class, 'checkValidated' ]);
                Route::get('show/{id}', [ AdminRepresentativeController::class, 'show' ]);
                Route::put('update', [ AdminRepresentativeController::class, 'update' ]);
                Route::put('reset-password', [ AdminRepresentativeController::class, 'resetPassword' ]);
                Route::delete('delete/{id}', [ AdminRepresentativeController::class, 'delete' ]);
            });

            Route::prefix('stores')->group(function() {
                Route::get('', [ AdminStoreController::class, 'index' ]);
                Route::get('get-employee/{number}', [ AdminStoreController::class, 'getEmployee' ]);
                Route::post('create', [ AdminStoreController::class, 'create' ]);
                Route::get('check-deleted/{id}', [ AdminStoreController::class, 'checkDeleted' ]);
                Route::post('check-validated', [ AdminStoreController::class, 'checkValidated' ]);
                Route::get('show/{id}', [ AdminStoreController::class, 'show' ]);
                Route::put('update', [ AdminStoreController::class, 'update' ]);
                Route::put('update-last-logged-in', [ AdminStoreController::class, 'updateLastLoggedIn' ]);
                Route::put('cancel-reset-password', [ AdminStoreController::class, 'cancelResetPassword' ]);
                Route::put('reset-password', [ AdminStoreController::class, 'resetPassword' ]);
                Route::delete('delete/{id}', [ AdminStoreController::class, 'delete' ]);
            });

            Route::prefix('messages')->group(function() {
                Route::get('get-store/{id}', [ MessageController::class, 'getStore' ]);
                Route::get('get-message', [ MessageController::class, 'getMessage' ]);
                Route::get('get-messages', [ MessageController::class, 'getMessages' ]);
            });
        });
    });

    Route::prefix('representative')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::post('login', [ RepresentativeAuthController::class, 'login' ]);
            Route::post('reset-password', [ RepresentativeAuthController::class, 'resetPassword' ]);
            Route::get('representative', [ RepresentativeAuthController::class, 'representative' ]);

            Route::middleware([ 'assign.guard:representatives', 'jwt.auth' ])->group(function() {
                Route::get('refresh', [ RepresentativeAuthController::class, 'refresh' ]);
                Route::get('check-deleted/{id}', [ RepresentativeAuthController::class, 'checkDeleted' ]);
                Route::post('logout', [ RepresentativeAuthController::class, 'logout' ]);
            });
        });

        Route::middleware([ 'assign.guard:representatives', 'jwt.auth' ])->group(function() {
            Route::prefix('setting')->group(function() {
                Route::post('change-password', [ RepresentativeSettingController::class, 'changePassword' ]);
                Route::post('change-email', [ RepresentativeSettingController::class, 'changeEmail' ]);
            });

            Route::prefix('messages')->group(function() {
                Route::get('get-stores/{id}', [ MessageController::class, 'getStores' ]);
                Route::get('get-message', [ MessageController::class, 'getMessage' ]);
                Route::get('get-messages', [ MessageController::class, 'getMessages' ]);
                Route::get('count-unread', [ MessageController::class, 'countUnread' ]);
                Route::put('mark-seen', [ MessageController::class, 'markSeen' ]);
                Route::post('send-message', [ MessageController::class, 'sendMessage' ]);
                Route::post('edit-message', [ MessageController::class, 'editMessage' ]);
                Route::post('send-to-sub-emails', [ MessageController::class, 'sendToSubEmails' ]);
                Route::delete('delete-message/{id}', [ MessageController::class, 'deleteMessage' ]);
            });
        });
    });

    Route::prefix('store')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::post('login', [ StoreAuthController::class, 'login' ]);
            Route::post('reset-password', [ StoreAuthController::class, 'resetPassword' ]);
            Route::get('user', [ StoreAuthController::class, 'user' ]);

            Route::middleware([ 'assign.guard:stores', 'jwt.auth' ])->group(function() {
                Route::get('refresh', [ StoreAuthController::class, 'refresh' ]);
                Route::get('check-deleted/{id}', [ StoreAuthController::class, 'checkDeleted' ]);
                Route::post('logout', [ StoreAuthController::class, 'logout' ]);
            });
        });

        Route::middleware([ 'assign.guard:stores', 'jwt.auth' ])->group(function() {
            Route::prefix('setting')->group(function() {
                Route::post('change-password', [ StoreSettingController::class, 'changePassword' ]);
                Route::post('change-email', [ StoreSettingController::class, 'changeEmail' ]);
            });

            Route::prefix('messages')->group(function() {
                Route::get('get-employee/{id}', [ MessageController::class, 'getEmployee' ]);
                Route::get('get-store/{id}', [ MessageController::class, 'getStore' ]);
                Route::get('get-message', [ MessageController::class, 'getMessage' ]);
                Route::get('get-messages', [ MessageController::class, 'getMessages' ]);
                Route::get('count-unread', [ MessageController::class, 'countUnread' ]);
                Route::put('mark-seen', [ MessageController::class, 'markSeen' ]);
                Route::post('send-message', [ MessageController::class, 'sendMessage' ]);
                Route::post('edit-message', [ MessageController::class, 'editMessage' ]);
                Route::delete('delete-message/{id}', [ MessageController::class, 'deleteMessage' ]);
            });

            Route::prefix('catalog')->group(function() {
                Route::get('get-list', [ CatalogController::class, 'getList' ]);
            });

            Route::prefix('purchase-history')->group(function() {
                Route::get('', [ PurchaseHistoryController::class, 'index' ]);
                Route::get('show/{id}', [ PurchaseHistoryController::class, 'show' ]);
                Route::post('reorder', [ PurchaseHistoryController::class, 'reorder' ]);
            });
        });
    });
});
