<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SellController extends Controller
{

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'quantity' => 'required'
            ], [
                'quantity.required' => 'Campo QUANTIDADE faltando!'
            ]);

            $products = CacheService::getProducts();
            $product = $products->firstWhere('id', $id);
            $product->stock -= $request->quantity;

            if ($product->stock <= 0) {
                return response()->json(['success' => true, 'msg' => "Produto nao tem o estoque necessario para a compra" ]);
            }


            $products->transform(function ($item) use ($product) {
                if($item->id == $product->id){
                    return $product;
                }
                return $item;
            });

            CacheService::updateProducts($products);
            return response()->json(['success' => true, 'msg' => "Produto Vendido com sucesso" ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => "Erro ao Vender produto: " . $e->getMessage()]);
        }
    }

}

