<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiAuthController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('refresh', 'refresh');
            Route::get('me', 'me');
            Route::prefix('token')
                ->group(function () {
                    Route::post('revoke', 'revokeToken');
                });
        });

    });
Route::controller(ProfileController::class)
    ->prefix('/profiles')
    ->group(
        function () {
            /** @uses ProfileController::index() */
            Route::get('', 'index');
            /** @uses ProfileController::show() */
            Route::get('/{profile}', 'show');
            Route::group(['middleware' => 'auth:api'], function () {
                /** @uses ProfileController::store() */
                Route::post('/', 'store');
                /** @uses ProfileController::update() */
                Route::put('/{profile}', 'update');
                /** @uses ProfileController::destroy() */
                Route::delete('/{profile}', 'destroy');
            });
        }

    );
