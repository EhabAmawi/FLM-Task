<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidatePromoCodeController;
use App\Http\Controllers\Admin\CreatePromoCodeController;

Route::post('/user/login', [AuthController::class, 'login']);

Route::prefix('/admin')
    ->middleware(['auth:sanctum', 'abilities:promo-codes.create'])
    ->group(function () {
        Route::post('promo-codes', CreatePromoCodeController::class);
    });

Route::post('promo-codes/validate', ValidatePromoCodeController::class)
    ->middleware(['auth:sanctum', 'abilities:promo-codes.validate']);
