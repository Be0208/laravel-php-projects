<?php

namespace App\Http\Controllers;

use App\Models\Jogo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Jogo::query();

        if($status === '1' || $status === '0'){
            $query->status($status);
        }

        return response()->json(['jogos' => $query->get()]);
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $jogo = Jogo::findOrFail($id);

            return response()->json(['success' => true, 'msg' => "Listado carro.", 'data' => $jogo ]);
        } catch(ModelNotFoundException $error){
            Log::error('Erro ao criar jogo: ' . $error->getMessage());
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'storage' => 'required',
                'score' => 'required|integer',
                'status' => 'required|boolean'
            ], [
                'name.required' => 'Campo nome é obrigatório!',
                'storage.required' => 'Campo storage é obrigatório!',
                'score.required' => 'Campo score é obrigatório!',
                'score.integer' => 'O campo score deve ser um número inteiro!',
                'status.required' => 'Campo status é obrigatório!',
                'status.boolean' => 'O campo status deve ser um booleano!'
            ]);

            $jogo = Jogo::create($request->all());

            return response()->json(['success' => true, 'msg' => "Jogo criado com sucesso.", "data" => $jogo]);

        } catch(ModelNotFoundException $error){
            Log::error('Erro ao criar jogo: ' . $error->getMessage());
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id){
        try {
            $request->validate([
                'name' => 'required',
                'storage' => 'required',
                'score' => 'required|integer',
                'status' => 'required|boolean'
            ], [
                'name.required' => 'Campo nome é obrigatório!',
                'storage.required' => 'Campo storage é obrigatório!',
                'score.required' => 'Campo score é obrigatório!',
                'score.integer' => 'O campo score deve ser um número inteiro!',
                'status.required' => 'Campo status é obrigatório!',
                'status.boolean' => 'O campo status deve ser um booleano!'
            ]);

            $jogo = Jogo::findOrfail($id);

            $jogo->fill([
                'name' => $request->name,
                'storage' => $request->storage,
                'score' => $request->score,
                'status' => $request->status
            ]);

            $jogo->save();

            return response()->json(['success' => true, 'msg' => 'Update do Jogo concluido!', 'data' => $jogo]);

        } catch(ModelNotFoundException $error){
            Log::error('Erro ao criar jogo: ' . $error->getMessage());
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try{
            $jogo = Jogo::findOrFail($id);

            $jogo->delete();

            return response()->json(['success' => true, 'mgs' => "Jogo excluido!", 'data' => $jogo->name]);

        } catch(ModelNotFoundException $error){
            Log::error('Erro ao deletar jogo: ' . $error->getMessage());
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
         }
    }
}
