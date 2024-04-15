<?php

use App\Http\Controllers\ProductControleler;
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





// Define um grupo de rotas prefixadas com '/admin'.
Route::prefix('admin')->group(function() {

    // Define uma rota GET para '/admin/users'.
    Route::get('/users', function (Request $request) {

        // Retorna uma resposta JSON indicando sucesso e uma mensagem específica para usuários do admin.
        return response()->json(['success' => true, 'msg' => "Users do Admin"]);
    });

    // Define uma rota GET para '/admin/categories'.
    Route::get('/categories', function (Request $request) {

        // Retorna uma resposta JSON indicando sucesso e uma mensagem específica para categorias do admin.
        return response()->json(['success' => true, 'msg' => "Categorias do Admin"]);
    });
});



// Agrupando por nomes, apenas por código, não altera a rota (neste caso a rota é /products)
Route::name('products.')->group(function() {
    // Define uma rota GET para '/products' e atribui o nome 'list' a esta rota.
    Route::get('/products', function (Request $request) {
        return response()->json(['success' => true, 'msg' => "Listando Produtos..."]);
    })->name('list');

    // Define uma outra rota GET para '/products' e atribui o nome 'show' a esta rota.
    Route::get('/products/{id}', function (Request $request) {
        return response()->json(['success' => true, 'msg' => "Listando Produtos..."]);
    })->name('show');
});

// Utilizamos isto para definir métodos de rota para serem usados no código
// EXEMPLO:
Route::get('/products/v1', function(Request $request) {
    // Redireciona para a rota com o nome 'products.list'
    return redirect()->route('products.list');
});
