<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardListController;
use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResource('boards', BoardController::class);
    Route::apiResource('boards.lists', BoardListController::class)
        ->scoped();
    Route::apiResource('boards.lists.cards', CardController::class)
        ->scoped();
});
