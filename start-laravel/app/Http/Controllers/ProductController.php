<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsCache = Cache::get('products');
        $productsCollect = collect([]);

        if($productsCache !== null){
            $productsCollect = collect(json_decode($productsCache));
        }

        return response()->json(['success' => true, 'msg' => "Litagem de produtos.", 'data' => $productsCollect]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productsCache = Cache::get('products');
        $products = collect([]);

        $data = $request->json()->all();

        if($productsCache !== null){
            $products = collect(json_decode($productsCache));
        }

        $products->push($data);

        Cache::put('products', $products->toJson());

        return response()->json(['success' => true, 'msg' => "Produto criado com sucesso."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productsCache = Cache::get('products');
        $products = collect([]);

        if($productsCache !== null){
            $products = collect(json_decode($productsCache));
        }

        $product = $products->firstWhere('id', $id);
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
            $productsCache = Cache::get('products');
            $products = collect([]);

            if($productsCache !== null){
                $products = collect(json_decode($productsCache));
            }

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

            Cache::put('products', $products->toJson());

            return response()->json(['success' => true, 'msg' => "Produto atualizado com sucesso."]);

        }


        return response()->json(['success' => false, 'msg' => "Campo nome e preço são obrigatórios."], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['success' => true, 'msg' => "Delete a categoria, $id."]);
    }
}
