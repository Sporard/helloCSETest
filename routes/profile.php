<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ProfileController::class)->group(
    function () {
        Route::prefix("/profile")->group(
            function () {
                Route::get("",  'index');
                Route::get("/{id}", 'show');
                Route::post('', 'store');
                Route::put("/{id}", "update" );
                Route::delete("/{id}", "destroy");

            }

        );
    }
);
