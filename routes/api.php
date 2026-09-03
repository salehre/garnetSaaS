<?php

use App\Http\Controllers\Api\PriceController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->get('/prices', [PriceController::class, 'index']);
