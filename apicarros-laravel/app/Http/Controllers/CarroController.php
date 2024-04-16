<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carros = Cache::get('carros');

        return response()->json(['carros' => json_decode($carros) ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    if(!$request->has(['id','modelo', 'marca'])){
        return response()->json(['error' => "Campos obrigatórios ausentes"]);
      }

     $carros = json_decode(Cache::get('carros'));

     $carro = $request->json()->all();
     $carros[] = $carro;


     Cache::put('carros', json_encode($carros));

      return response()->json(['success' => true, 'mgs' => "Carro adicionado com sucesso!"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carros = json_decode(Cache::get('carros'), true);


    foreach($carros as $carro){
        if($carro['id']  == $id){
            return response()->json(['carro' => $carro]);
        }
    }


    return response()->json(['error' => 'carro não encontrado!' ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carros = json_decode(Cache::get('carros'), true);


    foreach ($carros as $key => $carro) {
        if ($carro['id'] == $id) {
            array_splice($carros, $key, 1);
            Cache::put('carros', json_encode($carros));

        }
    }
    return response()->json(['success' => true, 'mgs' => "Carro excluido!"]);
    }
}
