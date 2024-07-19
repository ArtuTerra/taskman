<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
