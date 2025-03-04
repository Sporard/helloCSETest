<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
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
