<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [UsersController::class, "createUser"])->name('register');
    Route::post('/login', [UsersController::class, 'login'])->name('login');
    Route::get('/me', [UsersController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::prefix('products')
    ->middleware('auth:api')
    ->group(function () {
        Route::post('/', [ProductsController::class, "create"])->name('products.create');
    });

