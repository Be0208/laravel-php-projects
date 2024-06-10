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
        $authors = Book::with('author.name')->get();


        return response()->json(['success' => true, 'data' => $authors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'author_id' => 'required'
            ],
            [
                'required' => 'O campo :atribute é obrigatorio'
            ]);

            $books = Book::create($request->all());

            return response()->json(['success' => true, 'msg' => 'Book criado com sucesso', 'author' => $books]);


        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 401);
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
