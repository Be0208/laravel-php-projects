<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

// CRUD de produtos , essas são as funcionalidades:
// busca de um produto pelo id.
// -venda do produto.
// -compra do produto.
// -Ao gerar uma venda ou compra, altera o estoque do produto.

// *Todas as operações de CRUD e de movimentação de estoque devem ser salvas em cache.

Route::get('/produto/{id}', function(Request $request, $id){
    $produtos = json_decode(Cache::get('produtos'));
    $produto = collect($produtos)->firstWhere('id', $id);

    if($produto){
        return response()->json(["success" => true, 'produto: ' => json_encode($produto)]);
    }
    else
    {
        return response()->json(["success" => false, 'msg' => 'Produto Não Encontrado']);
    }

});

Route::post('/produto', function(Request $request){
    if($request->has(['id','nome', 'valor', 'quantidade'])){

            $produtos = json_decode(Cache::get('produtos'));
            $produtos[] = $request->json()->all();

            Cache::put('produtos', json_encode($produtos));
            return response()->json(['msg' => 'Produto Cadastrado']);
    }

    return response()->json(['error' => "Campos obrigatórios ausentes"]);
});

Route::put('/produto/venda/{id}', function(Request $request, $id){
    $produtos = json_decode(Cache::get('produtos'));
    $produto = collect($produtos)->firstWhere('id', $id);

    if($produto){
        $produto->quantidade -= $request['quantidade'];

        Cache::put('produtos', json_encode($produtos));

        return response()->json(["success" => true, 'msg' => 'Venda Concluida']);
    }

    return response()->json(["success" => false, 'msg' => 'Venda não Concluida']);
});

Route::put('/produto/compra/{id}', function(Request $request, $id){
    $produtos = json_decode(Cache::get('produtos'));
    $produto = collect($produtos)->firstWhere('id', $id);

    if($produto){
        $produto->quantidade += $request['quantidade'];

        Cache::put('produtos', json_encode($produtos));

        return response()->json(["success" => true, 'msg' => 'Compra Concluida']);
    }

    return response()->json(["success" => false, 'msg' => 'Falha na Compra']);
});
