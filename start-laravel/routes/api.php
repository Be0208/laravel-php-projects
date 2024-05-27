<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ExistProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;


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

Route::get('/', function (Request $request){
    return response()->json(['success' => true, 'msg' => "Hello world!"]);
});

// Route::post('/users', [UserController::class, 'create']);

Route::get('/users/{id}', function(Request $request, $id){

    return response()->json(['success' => true, 'msg' => "Você mandou o user {$id}!"]);
});

Route::get('/users/marcelo/cache', function(Request $request){
    $user = json_decode(Cache::get('user'));

    dd($user->name);
});

Route::resource('/products', ProductController::class);

Route::resource('/categories', CategoryController::class);

Route::resource('/people', PersonController::class);
Route::get('/people/{id}/received', [PersonController::class, 'update']);
