<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::post('/users', [UserController::class, 'create']);

Route::get('/users/{id}', function(Request $request, $id){

    return response()->json(['success' => true, 'msg' => "Você mandou o user {$id}!"]);
});

Route::get('/users/marcelo/cache', function(Request $request){
    $user = json_decode(Cache::get('user'));

    dd($user->name);
});

//MUDA A URL
Route::prefix('sandro')->group(function(){
    Route::get('/users', function(Request $request){
        return response()->json(['success'=> true, 'msg' => "Users do admin"]);
    });

    Route::get('/categories', function(Request $request){
        return response()->json(['success'=> true, 'msg' => "Categorias do admin"]);
    });
});

//NAO MUDA A URL - APENAS PARA REFERENCIA NO CODIGO
Route::name('products. ')->group(function(){
    Route::get('/products', [ProductController::class, 'listAll'])->name('list');

    Route::post('/products', [ProductController::class, 'create'])->name('create');

    Route::get('/products/{id}', function(Request $request){
        return response()->json(['success' => true, 'msg' => "Litando os produtos..."]);
    })->name('show');
});

Route::get('/products/v1', function(Request $request){
    return redirect()->route('products.list');
});

Route::resource('/categories', CategoryController::class);
