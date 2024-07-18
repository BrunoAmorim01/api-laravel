<?php

use App\Http\Controllers\ProductMovimentationController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [UsersController::class, "createUser"])->name('register');
    Route::post('/login', [UsersController::class, 'login'])->name('login');
    Route::get('/me', [UsersController::class, 'me'])
        ->middleware('auth:sanctum')
        ->name('me');
});

Route::prefix('products')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/', [ProductsController::class, "create"])->name('products.create');
        Route::get('/', [ProductsController::class, "index"])->name('products.index');
        Route::get('/{id}', [ProductsController::class, "show"])
            ->name('products.show');
        Route::put('/{id}', [ProductsController::class, "update"])->name('products.update');
    });

Route::prefix('product-movimentation')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/', [ProductMovimentationController::class, "create"])->name('product-movimentation.create');
        Route::get('/', [ProductMovimentationController::class, "index"])->name('product-movimentation.index');
        Route::get('/export', [ProductMovimentationController::class, "export"])->name('product-movimentation.export');
    });

Route::prefix('tools')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/cep/{zipcode}', [ToolsController::class, "getCep"])->name('tools.cep');
    });

