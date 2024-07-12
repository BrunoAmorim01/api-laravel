<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// Route::post("/users", [UsersController::class, "createUser"]);
// Route::get("/", function () {
//     return response()->json(["message" => "Hello World!"], 200);
// });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [UsersController::class, "createUser"])->name('register');
    Route::post('/login', [UsersController::class, 'login'])->name('login');
    Route::get('/me', [UsersController::class, 'me'])->middleware('auth:api')->name('me');
});
