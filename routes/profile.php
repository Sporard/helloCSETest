<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ProfileController::class)
    ->prefix('/profiles')
    ->group(
        function () {
            Route::get('', 'index');
            Route::get('/{profile}', 'show');
            Route::group(['middleware' => 'auth'], function () {
                Route::post('/', 'store');
                Route::put('/{profile}', 'update');
                Route::delete('/{profile}', 'destroy');
            });
        }

    );
