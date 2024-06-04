<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('/users', UserController::class);

Route::resource('/login', AuthController::class);

Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('biblioteca', BookController::class);
});
