<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logOut'])->middleware('auth:sanctum') ;
Route::get("/tasks/disk", [TaskController::class, "disk"])->middleware('auth:sanctum');

Route::post('/tasks', [TaskController::class, 'addTasks'])->middleware('auth:sanctum') ;
Route::post('/tasks/{id}', [TaskController::class, 'uploadTasks'])->middleware('auth:sanctum') ;
Route::delete('/tasks/{id}', [TaskController::class, 'deleteTask'])->middleware('auth:sanctum') ;

Route::middleware('auth:sanctum')->get('/tasks/{taskId}', [TaskController::class, 'getTask']);
