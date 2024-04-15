<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;


class ProductControleler extends Controller
{
    public function listAll(){
        $productsCache = Cache::get('products');
        $products = [];

        if($productsCache !== null){
            $products = json_encode($productsCache);
        }

        return response()->json(["success" => true, "msg" => "Lista de Produtos!!", 'data' => $products]);
    }
}
