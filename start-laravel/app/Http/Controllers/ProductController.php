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
        $products = Product::all();

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
    public function show(Request $request, string $id)
    {
        $product = $request->get('product');

        return response()->json(['success' => true, 'msg' => "Listado produto.", 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if(collect($request)->has('name', 'price')){
            $products = Product::all();

            $product = $products->firstWhere('id', $id);

            if($product == null){
                return response()->json(['success' => false, 'msg' => "Produto não encontrado."], 404);
            }

            $product->name = $request->name;
            $product->price = $request->price;

            $index = $products->search(function ($item) use ($id) {
                return $item->id == $id;
            });

            $products->replace($index, collect($product)->all());

            CacheService::updateProducts($products);

            return response()->json(['success' => true, 'msg' => "Produto atualizado com sucesso."]);

        }

        return response()->json(['success' => false, 'msg' => "Campo nome e preço são obrigatórios."], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $products = Product::all();

        $product = $products->firstWhere('id', $id);

        if($product == null){
            return response()->json(['success' => false, 'msg' => "Produto não encontrado."], 404);
        }

        $filtered = $products->reject(function ($item) use ($id){
            if(collect($item)->has('id')){
                return $item->id == $id;
            }

            return false;
        })->values()->collect();

        CacheService::updateProducts($filtered);

        return response()->json(['success' => true, 'msg' => "Delete produto, $id."]);
    }
}
