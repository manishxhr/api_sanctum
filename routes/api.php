<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register',[UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
// Route::post('logout',[UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[UserController::class, 'logout']);

    Route::get('tasks',[TaskController::class,'index']);
    Route::post('/create',[TaskController::class, 'create']);
    Route::get('/task/{id}',[TaskController::class, 'show']);
    Route::delete('/task/delete/{id}',[TaskController::class, 'delete']);
    Route::put('update/{id}',[TaskController::class, 'update']);


});


