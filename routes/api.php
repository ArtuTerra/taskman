<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::middleware('auth:api')->group(function () {
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [UserController::class, 'listusers']);
    Route::get('tasks/assigns', [TaskController::class, 'listTasksAssigns']);
    Route::post('tasks/assign/{task}', [UserController::class, 'assign']);
    Route::delete('tasks/assign/{task}', [UserController::class, 'removeAssign']);
    Route::apiResource('tasks', TaskController::class);
});
