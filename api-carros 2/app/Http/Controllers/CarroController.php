<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carros = CacheService::getCarros();

        return response()->json(['carros' => $carros]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!$request->has(['id', 'modelo', 'marca'])) {
            return response()->json(['error' => "Campos obrigatórios ausentes"]);
        }

        $carros = CacheService::getCarros();

        $carro = $request->json()->all();

        $carros->push($carro);

        CacheService::updateCarros($carros);

        return response()->json(['success' => true, 'mgs' => "Carro adicionado com sucesso!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carros = CacheService::getCarros();


        $carro = $carros->firstWhere('id', $id);

        if ($carro == null) {
            return response()->json(['success' => false, 'msg' => "carro não encontrado."], 404);
        }


        return response()->json(['success' => true, 'msg' => "Listado carro.", 'data' => $carro]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if (!collect($request)->has('modelo', 'marca')) {
            return response()->json(['success' => false, 'msg' => "Campos não informados!"]);
        }

        $carros = CacheService::getCarros();

        $carro = $carros->firstWhere('id', $id);


        if ($carro == null) {
            return response()->json(['success' => false, 'msg' => "carro não encontrado."], 404);
        }


        $carrosEditado = $carros->map(function ($item) use ($request, $id) {

            if ($item->id == $id) {
                $item->modelo = $request->modelo;
                $item->marca = $request->marca;
            }

            return $item;
        });

        CacheService::updateCarros($carrosEditado);


        return response()->json(['success' => true, 'mgs' => "Carro editado!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        $carros = CacheService::getCarros();


        $carrosNovo = $carros->reject(function ($carro) use ($id) {
            return $carro->id == $id;
        });

        CacheService::updateCarros($carrosNovo);


        return response()->json(['success' => true, 'mgs' => "Carro excluido!"]);
    }
}
