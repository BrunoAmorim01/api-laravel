<?php
use App\Http\Controllers\HomeController;

Route::get('/', function () {
        Log::info('Welcome page accessed');
    return view('welcome'); });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');
Route::get('/messages', [HomeController::class, 'messages'])
    ->name('messages');
Route::post('/message', [HomeController::class, 'message'])
    ->name('message');
