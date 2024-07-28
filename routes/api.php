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
    Route::get('users/created', [UserController::class, 'listusersC']);
    Route::get('users/assigned', [UserController::class, 'listusersA']);
    Route::get('relations', [UserController::class, 'listrelations']);
    Route::post('assign', [UserController::class, 'assign']);
    Route::post('newtask', [TaskController::class, 'store']);
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/assigns', [TaskController::class, 'listTasksAssigns']);
    Route::get('task/{id}', [TaskController::class, 'show']);
    Route::put('task/{id}', [TaskController::class, 'update']);
    Route::delete('task/{id}', [TaskController::class, 'destroy']);
});

Route::controller(TaskController::class)->group(function () {
    Route::get('/public/tasks', [TaskController::class, 'index']);
    Route::get('/public/relations', [TaskController::class, 'listrelations']);
    Route::get('/public/users', [TaskController::class, 'listusers']);

});
