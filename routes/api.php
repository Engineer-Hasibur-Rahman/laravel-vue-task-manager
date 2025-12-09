<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware([
    EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    'auth:sanctum',
])->group(function () {
    // Auth routes
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);

    // Task routes
    Route::get('/tasks/stats', [TaskController::class, 'stats']);
    Route::apiResource('tasks', TaskController::class);
});
