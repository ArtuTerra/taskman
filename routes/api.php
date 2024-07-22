<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::middleware('auth:api')->group(function () {
    Route::get('users', [AuthController::class, 'listusers']);
    Route::post('refresh', [AuthController::class,  'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('task/assign', [TaskController::class, 'assign']);
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('task', [TaskController::class, 'store']);
    Route::get('task/{id}', [TaskController::class, 'show']);
    Route::put('task/{id}', [TaskController::class, 'update']);
    Route::delete('task/{id}', [TaskController::class, 'destroy']);
});

Route::controller(TaskController::class)->group(function () {
    Route::get('/public/tasks', [TaskController::class, 'index']);
});
