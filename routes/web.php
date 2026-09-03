<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerChartController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only (login) routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    // Everything below requires an authenticated admin
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('customers', CustomerController::class)->except(['show']);
        Route::post('customers/{customer}/regenerate-key', [CustomerController::class, 'regenerateApiKey'])
            ->name('customers.regenerate-key');
        Route::get('customers/{customer}/chart', [CustomerChartController::class, 'show'])
            ->name('customers.chart');
        Route::get('customers/{customer}/chart-data', [CustomerChartController::class, 'data'])
            ->name('customers.chart-data');

        Route::resource('currencies', CurrencyController::class)->only(['index', 'edit', 'update']);
    });
});