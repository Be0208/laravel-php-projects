<?php

namespace App\Http\Controllers;

use App\Models\Author;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::with('books')->get();
        //dentro do WITH vai o nome da função que esta no model, pois ele vai puxar os books que o autor tem

        return response()->json(['success' => true, 'data' => $authors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ],
            [
                'required' => 'O campo :atribute é obrigatorio'
            ]);

            $author = Author::create($request->all());

            return response()->json(['success' => true, 'msg' => 'Author criado com sucesso', 'author' => $author]);


        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 401);
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $author = Author::with('books')->findOrFail($id);

            return response()->json(['success' => true, 'data' => $author]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, "msg" => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
             'name' => 'required'
            ],
            [
             'required' => 'O campo :atribute é obrigatório!'
            ]);

            $author = Author::findOrFail($id);

           $author->fill([
                'name' => $request->name
           ]);

           $author->save();

            return response()->json(['success' => true, 'msg' => 'autor ediatado com sucesso!', 'data' => $author]);

         } catch (\Throwable $th) {
             return response()->json(['success' => false, 'msg' =>  $th->getMessage()]);
         }
    }



    public function destroy(string $id)
    {
       $author = Author::findOrFail($id);

       $author->delete();

       return response()->json(['success' => true, 'msg' => 'autor deletado!']);
    }
}
