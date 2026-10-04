<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteApiController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('landing');
Route::get('/store/{site:subdomain}', StoreController::class)->name('store');
Route::get('/api/subdomain', [AuthController::class, 'checkSubdomain']);

Route::middleware('guest')->group(function () {
    Route::view('/signup', 'signup')->name('signup');
    Route::view('/login', 'login')->name('login');
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('api')->group(function () {
        Route::put('/site', [SiteApiController::class, 'update']);
        Route::put('/site/toggle', [SiteApiController::class, 'toggle']);
        Route::post('/products', [SiteApiController::class, 'storeProduct']);
        Route::put('/products/{id}', [SiteApiController::class, 'updateProduct']);
        Route::delete('/products/{id}', [SiteApiController::class, 'destroyProduct']);
        Route::post('/orders/{id}/advance', [SiteApiController::class, 'advanceOrder']);
        Route::put('/plan', [SiteApiController::class, 'changePlan']);
        Route::post('/welcome/dismiss', [SiteApiController::class, 'dismissWelcome']);
        Route::delete('/account', [SiteApiController::class, 'destroyAccount']);
    });
});
