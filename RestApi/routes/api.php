<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{ArticleController, TagController};

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::apiResource('tags', TagController::class)->only(['index','show']);
Route::apiResource('articles', ArticleController::class)->only(['index','show']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('tags', TagController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});
