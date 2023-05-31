<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/health', function () {
    return 'Bienvenido a mi app';
});

// TASKS
Route::group(
    [
        'middleware' => ['auth:sanctum', 'ejemplo']
    ],
    function () {
        Route::get('/tasks', [TaskController::class, 'getTasksByUserId']);
        Route::post('/tasks', [TaskController::class, 'createTask']);
        Route::put('/tasks/{id}', [TaskController::class, 'updateTaskById']);
        Route::delete('/tasks/{id}', [TaskController::class, 'deleteTaskById']);
    }
);

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');

// USER
Route::group(
    [
        'middleware' => ['auth:sanctum', 'isAdmin']
    ],
    function () {
        Route::get('/users', [UserController::class, 'getAllUsers']);
    }
);
