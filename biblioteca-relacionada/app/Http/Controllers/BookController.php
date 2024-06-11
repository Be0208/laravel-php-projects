<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::with('author')->get());
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'author_id' => 'required',
            ], [
                'required' => 'O campo :atribute é obrigatório!'
            ]);

            $book = Book::create($request->all());
            return response()->json(['success' => true, 'msg' => "Livro criado com sucesso!", "data" => $book], 200);
            
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        }

    }

    public function show($id)
    {
        try {
            $book = Book::findOrfail($id);
            return response()->json(['success' => true, 'msg' => "livro listado!", "data" => $book], 200);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        };
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'author_id' => 'required',
            ], [
                'required' => 'O campo :atribute é obrigatório!'
            ]);

            $book = Book::findOrfail($id);

            $book->fill([
                'name' => $request->name,
                'description' => $request->description,
                'author_id' => $request->author_id
            ]);

            $book->save();
            return response()->json(['success' => true, 'msg' => "livro atualizado!", "data" => $book], 200);
        } catch (\Exception $error) {
            return response()->json(['success' => false, 'msg' => $error->getMessage()], 400);
        };
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}
