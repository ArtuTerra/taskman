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
    Route::get('users/assigns', [UserController::class, 'listusersA']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/assigns', [TaskController::class, 'listTasksAssigns']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
    Route::post('tasks/assign/{task}', [UserController::class, 'assign']);
});

Route::controller(TaskController::class)->group(function () {
    Route::get('/public/tasks', [TaskController::class, 'index']);
    Route::get('/public/relations', [TaskController::class, 'listrelations']);
    Route::get('/public/users', [TaskController::class, 'listusers']);

});

Route::controller(AuthController::class)->group(function () {
    Route::post('/verifyemail', [AuthController::class, 'emailVerification']);
});
