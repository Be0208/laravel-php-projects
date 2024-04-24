<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsCollect = CacheService::getProducts();

        return response()->json(['success' => true, 'msg' => "Litagem de produtos.", 'data' => $productsCollect]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $request->validate([
                'name'=> 'required',
                'price'=> 'required',
                'id' => 'required',
                'stock' => 'required'

            ], [
                'name.required' => 'Campo nome é obrigatório.',
                'price.required' => 'Campo preço é obrigatório.',
                'id.required' => 'Campo id é obrigatório.',
                'stock.required' => 'Campo stock é obrigatório.'

            ]);

            // Supondo que CacheService seja acessível e seus métodos estejam corretamente definidos
            $products = CacheService::getProducts();

            // Supondo que você esteja recebendo dados JSON no corpo da solicitação
            $data = $request->json()->all();

            // Adiciona os dados do novo produto aos produtos existentes
            $products->push($data);

            // Atualiza a cache com os produtos atualizados
            CacheService::updateProducts($products);

            return response()->json(['success' => true, 'msg' => "Produto criado com sucesso."]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'msg' => "Erro ao criar produto: " . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = CacheService::getProducts();

        $product = $products->firstWhere('id', $id);
        if($product == null){
            return response()->json(['success' => false, 'msg' => "Produto nao encontrado."], 404);
        }

        return response()->json(['success' => true, 'msg' => "Listado produto.", 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if(collect($request)->has('name', 'price')){

            $products = CacheService::getProducts();

            $product = $products->firstWhere('id', $id);

            if($product == null){
                return response()->json(['success' => false, 'msg' => "Produto nao encontrado."], 404);
            }

            $product->name = $request->name;
            $product->price = $request->price;

            $index = $products->first(function ($item) use ($id) {
                return $item->id == $id;
            });

            $products->replace($index, collect($product)->all());

            CacheService::updateProducts($products);

            return response()->json(['success' => true, 'msg' => "Produto atualizado com sucesso."]);

        }

        return response()->json(['success' => false, 'msg' => "Campo nome e preco sao obrigatorios."], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $products = CacheService::getProducts();

        $product = $products->firstWhere('id', $id);

        if($product == null){
            return response()->json(['success' => false, 'msg' => "Produto nao encontrado."], 404);
        };

        $filtred = $products->reject(function ($item) use ($id) {
            return $item->id == $id;
        });

        CacheService::updateProducts($filtred);

        return response()->json(['success' => true, 'msg' => "Produto deletado: $id."]);
    }
}
