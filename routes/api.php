<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResource('boards', BoardController::class);
    Route::apiResource('boards.lists', BoardListController::class);
   // Route::apiResource('boards.lists.cards', CardController::class);
});
