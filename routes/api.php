<?php

use App\Http\Controllers\ClothingController;
use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:60,1'])->group(function () {
    Route::resource('clothing', ClothingController::class)->only(['index', 'store', 'update', 'show']);
    Route::post('clothing/discount', [DiscountController::class, 'calculate']);
});
