<?php

namespace App\Http\Controllers;

use App\Models\livro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LivrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->has('nome')) {
                $livro = livro::where('nome', $request->nome)->get();
                return response()->json(['nome' => $livro]);
            }

            $livros = livro::all();

            return response()->json(['nome' => $livros]);

        }catch(ModelNotFoundException $error){
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
                'nome' => 'required',
                'autor' => 'required',
                'paginas' => 'required'
            ],
            [
                'nome.required' => 'Campo titulo obrigatorio',
                'autor.required' => 'Campo autor obrigatorio',
                'paginas.required' => 'Campo numero de paginas obrigatorio'
            ]);

            $livro = livro::create($request->all());

            return response()->json(['success' => true, 'msg' => "Carro criado com sucesso.", 'data' => $livro]);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $livro = livro::findOrFail($id);
            return response()->json(['success' => true, 'msg' => "Listado carro.", 'data' => $livro ]);
        }catch(ModelNotFoundException $error){
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nome' => 'required',
                'autor' => 'required',
                'paginas' => 'required'
            ],
            [
                'nome.required' => 'Campo nome obrigatorio',
                'autor.required' => 'Campo autor obrigatorio',
                'paginas.required' => 'Campo numero de paginas obrigatorio'
            ]);

            $livro = livro::findOrFail($id);



            $livro->fill([
                'nome' => $request->nome,
                'autor' => $request->autor,
                'paginas' => $request->paginas

            ]);
            //save() para salvar a alteracao no banco de dados
            $livro->save();

            return response()->json(['success' => true, 'mgs' => "Livro editado!", 'data' => $livro]);

        } catch (ModelNotFoundException $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $livro = livro::findOrFail($id);
            $livro->delete();

            return response()->json(['success' => true, 'mgs' => 'Livro deletado da biblioteca com sucesso', 'data' => $livro]);

        }catch(ModelNotFoundException $error){
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 404);
        }
    }
}
