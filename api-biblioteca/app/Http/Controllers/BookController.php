<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookInfo = Book::select('title', 'author')->get();

        // $title = Book::pluck('title');
        // $dados = '';

        // foreach (Book::All() as $info) {
        //     $dados .= <<<EOL
        //     Tittle: {$info->title}, Author: {$info->author}

        //     EOL;
        // };

        // $author = Book::pluck('author');

        return response()->json(['success' => true, 'msg' => "Lista de livros:", "data" => $bookInfo], 200);;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'author' => 'required'
            ], [
                'required' => 'O campo :atribute é obrigatório!'
            ]);

            $book = Book::create($request->all());
            return response()->json(['success' => true, 'msg' => "Livro criado com sucesso!", "data" => $book], 200);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $book = Book::findOrfail($id);
            return response()->json(['success' => true, 'msg' => "Livro listado!", "data" => $book], 200);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'author' => 'required'
            ], [
                'required' => 'O campo :atribute é obrigatório!'
            ]);

            $book = Book::findOrfail($id);

            $book->fill([
                'title' => $request->title,
                'description' => $request->description,
                'author' => $request->author
            ]);

            $book->save();
            return response()->json(['success' => true, 'msg' => "Livro atualizado!", "data" => $book], 200);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response()->json(['success' => 'true', 'msg' => 'Usuário deletado com sucesso', 'data' => $book]);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }

    }
}
