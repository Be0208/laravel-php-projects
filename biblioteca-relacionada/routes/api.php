<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserController;
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

Route::prefix('borrowings')->group(function () {
    Route::get('/', [BorrowingController::class, 'index']);
    Route::post('/', [BorrowingController::class, 'store']);
    Route::get('/{user_id}/{book_id}', [BorrowingController::class, 'show']);
    Route::put('/{user_id}/{book_id}', [BorrowingController::class, 'update']);
    Route::delete('/{user_id}/{book_id}', [BorrowingController::class, 'destroy']);
});
