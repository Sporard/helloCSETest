<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiAuthController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('refresh', 'refresh');
        Route::group(['middleware' => 'auth:api'], function () {
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
            Route::get('', 'index');
            Route::get('/{profile}', 'show');
            Route::group(['middleware' => 'auth:api'], function () {
                Route::post('/', 'store');
                Route::put('/{profile}', 'update');
                Route::delete('/{profile}', 'destroy');
            });
        }

    );
