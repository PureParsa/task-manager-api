<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardListController;
use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('boards', BoardController::class);
    Route::apiResource('boards.lists', BoardListController::class)->scoped();

    Route::patch('boards/{board}/lists/{list}/cards/{card}/move', [CardController::class, 'move']);

    Route::apiResource('boards.lists.cards', CardController::class)->scoped();
});
