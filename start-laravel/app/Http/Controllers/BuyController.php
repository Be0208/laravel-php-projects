<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BuyController extends Controller
{

    //Incrementar o produto no stock

    public function store(Request $request, int $id)
    {
        try {
            $request->validate([
                'quantity' => 'required'
            ], [
                'quantity.required' => 'Campo QUANTIDADE faltando!'
            ]);

            $products = CacheService::getProducts();
            $product = $products->firstWhere('id', $id);
            $product->stock += $request->quantity;

            $products->transform(function ($item) use ($product) {
                if($item->id == $product->id){
                    return $product;
                }
                return $item;
            });

            CacheService::updateProducts($products);
            return response()->json(['success' => true, 'msg' => "Produto comprado com sucesso" ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => "Erro ao Comprar produto: " . $e->getMessage()]);
        }
    }

}
