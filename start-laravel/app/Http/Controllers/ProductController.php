<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CacheService;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {// pegar os dados da minha tabela do banco de dados

        //sem consição:
        $products = Product::all();

        //com condição:
        // $products = Product::where('enable', 1)->get();

        return response()->json(['success' => true, 'msg' => "Listagem de produtos.", 'data' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        $products = Product::create($request->all());

        return response()->json(['success' => true, 'msg' => "Produto criado com sucesso.", 'data' => $products]);

    } catch (\Throwable $e) {
        Log::error('Erro ao criar produto.', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'msg' => "Campo nome e preço são obrigatórios."], 400);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Product::find($id);

        if($product == null){
            return response()->json(['success' => false, 'msg' => "Produto não encontrado."], 404);
        }

        return response()->json(['success' => true, 'msg' => "Listado produto.", 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if(collect($request)->has('name', 'price')){

            $product = Product::find($id);

            if($product == null){
                return response()->json(['success' => false, 'msg' => "Produto não encontrado."], 404);
            };

            $product->name = $request->name;
            $product->price = $request-> price;

            $product->save();

            return response()->json(['success' => true, 'msg' => "Produto atualizado com sucesso."]);

        }

        return response()->json(['success' => false, 'msg' => "Campo nome e preço são obrigatórios."], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = Product::find($id);
        if($product == null){
            return response()->json(['success' => false, 'msg' => "Produto não encontrado."], 404);
        };

        $product->delete();

        return response()->json(['success' => true, 'msg' => "Delete produto, $id."]);
    }
}
