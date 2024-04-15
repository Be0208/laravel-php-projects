<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function listAll(){
        $productsCache = Cache::get('products');
        $productsCollect = collect([]);

        if($productsCache !== null){
            $productsCollect = collect(json_decode($productsCache));
        }

        return response()->json(['success' => true, 'msg' => "Litagem de produtos.", 'data' => $productsCollect]);
    }

    public function create(Request $request){
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
}
