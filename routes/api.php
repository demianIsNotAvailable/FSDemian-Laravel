<?php

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

Route::get('/tasks', function () {
    return [
        "success" => true,
        "message" => "Get tasks retrieved successfully",
        "data" => []
    ];
});

Route::post('/tasks', function () {
    return [
        "success" => true,
        "message" => "Create task successfully",
        "data" => []
    ];
});

Route::put('/tasks/{id}', function (string $id) {
    return [
        "success" => true,
        "message" => "Update task successfully with id: ".$id,
    ];
});

Route::delete('/tasks/{id}', function (string $id) {
    return [
        "success" => true,
        "message" => "Delete task successfully with id: ".$id,
    ];
});
