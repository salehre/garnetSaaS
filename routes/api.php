<?php

use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\ServiceCallController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->group(function () {
    Route::get('/prices', [PriceController::class, 'index']);
    Route::post('/services', [ServiceCallController::class, 'handle']);
});