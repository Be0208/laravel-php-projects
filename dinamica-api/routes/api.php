<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::resource('/users', UserController::class);

Route::resource('/login', AuthController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/posts', PostController::class);
    Route::apiResource('/likes', LikeController::class);
    Route::get('/reports', [ReportController::class, 'index']);
});
