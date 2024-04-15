<?php

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

// mexendo com a marequisição e implementação de dados na api

Route::get('/', function (Request $request){
    return response()->json(['success' => true, 'msg' => 'Hello world!']);
});

Route::post('/users', function (Request $request){
    $data = $request->json()->all();
    //dd($data); //envia e mata o servidor || mostra o valor a variavel

    Cache::put('users', json_encode($data));

    return response()->json(['success' => true, 'msg' => 'Usuario salvo!']);
});

Route::get('/users/{id}', function (Request $request, $id){
    return response()->json(["success' => false, 'msg' => `Voce mandou o user {$id}!"]);
});

Route::get('/users/bernarda/cache', function (Request $request){
    $users = Cache::get('users');

    dd(json_decode($users));
});

Route::get('/products/v1', function(Request $request){
    return redirect()-route('products.list'); // redirecionamento com o apelido das rotas
});

Route::get('/products', function(Request $request){
    return response()->json(["success" => true, 'msg' => "listando os produtos" ]);

})->name('products.list'); // apelido; alias; nome da minha rota

// grupo de rotas especificas:
    Route::prefix('admin')->group(function (){
        Route::get('users', function (Request $request){
            return response()->json(["success" => true, "msg" => "Users do admin"]);
        });
        Route::get('categories', function (Request $request){
            return response()->json(["success" => true, "msg" => "Users do categories"]);
        });
    });
    // para acessar essas rotas coloque o /... 'rota que deseja'

    Route::prefix('products. ')->group(function (){

    });
