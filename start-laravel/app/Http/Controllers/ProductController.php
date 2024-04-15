<?php

namespace App\Http\Controllers;

use Dflydev\DotAccessData\Data;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;


class ProductControleler extends Controller
{
    public function listAll() {
        $productsCache = Cache::get('products');
        $products = [];

        if ($productsCache !== null) {
            $products = json_encode($productsCache);
        };
        return response()->json(['success' => true, 'msg' => "Listagem de Produtos.", 'data' => $products]);
    }

    public function create(Request $request) {
        $productsCache = Cache::get('products');
        $products = [];

        $data = $request->json()->all();

        if ($productsCache !== null) {
            $products = json_decode($productsCache);
        };
        array_push($products, $data);
        Cache::put('products', json_encode($products));

        return response()->json(['success' => true, 'msg' => "Produto Criado com Sucesso."]);
    }
}
