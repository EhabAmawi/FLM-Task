<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidatePromoCodeController;
use App\Http\Controllers\Admin\CreatePromoCodeController;

Route::prefix('/admin')
//    ->middleware(['']) // TODO: Add admin middleware here
    ->group(function () {
        Route::post('promo-codes', CreatePromoCodeController::class);
    });

Route::post('promo-codes/validate', ValidatePromoCodeController::class);
