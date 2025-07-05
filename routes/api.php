<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/task', [TaskController::class, 'store']);
Route::get('/task', [TaskController::class, 'index']);
Route::put('/task-status/{id}', [TaskController::class, 'changeStatus']);
Route::put('/task/{id}', [TaskController::class, 'update']);
Route::delete('/task/{id}', [TaskController::class, 'delete']);