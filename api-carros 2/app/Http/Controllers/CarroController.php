<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\CacheService;
use Dflydev\DotAccessData\Data;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->has('modelo')){
            $carro = Car::where('modelo', $request->modelo)->get();

            return response()->json(['carro' => $carro]);
        }

        $carros = Car::all();

        return response()->json(['carros' => $carros]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'marca' => 'required',
                'modelo' => 'required'
            ],
            [
                'marca.required' => 'Campo marca obrigatorio',
                'modelo.required' => 'Campo modelo obrigatorio'
            ]);

            $car = Car::create($request->all());

            return response()->json(['success' => true, 'msg' => "Carro criado com sucesso.", 'data' => $car]);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $carro = Car::findOrFail($id);
            return response()->json(['success' => true, 'msg' => "Listado carro.", 'data' => $carro ]);
        }catch(ModelNotFoundException $error){
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'marca' => 'required',
                'modelo' => 'required'
            ],
            [
                'marca.required' => 'Campo marca obrigatorio',
                'modelo.required' => 'Campo modelo obrigatorio'
            ]);

            $carro = Car::findOrFail($id);

            // $carro->marca = $request->marca;
            // $carro->modelo = $request->modelo;
                            //ou

            $carro->fill([
                'marca' => $request->marca,
                'modelo' => $request->modelo
            ]);
            //save() para salvar a alteracao no banco de dados
            $carro->save();

            return response()->json(['success' => true, 'mgs' => "Carro editado!", 'data' => $carro]);

        } catch (ModelNotFoundException $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        try{
            $carro = Car::findOrFail($id);
            $carro->delete();

            return response()->json(['success' => true, 'mgs' => "Carro excluido!", 'data' => $carro]);
        }catch(ModelNotFoundException $error){
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }
}
