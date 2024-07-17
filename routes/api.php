<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function ($router) {
//     Route::post('/register', [AuthController::class, 'register'])->name('register');
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
//     Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
//     Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
//     Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
// });

use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');

});

Route::controller(TaskController::class)->group(function () {
    Route::get('users', 'listusers');
    Route::post('task/assign', 'assign');
    Route::get('tasks', 'index');
    Route::post('task', 'store');
    Route::get('task/{id}', 'show');
    Route::put('task/{id}', 'update');
    Route::delete('task/{id}', 'destroy');
});