<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('books')->get();
        return response()->json(['success' => true, 'msg' => 'Tags listadas com sucesso.', 'data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'book_id' => 'required|exists:books,id',
                'due_date' => 'required|date'
            ]);

            $user = User::find($request->user_id);

            // criando registros a tabela pivô
            $user->books()->attach($request->book_id, [
                'borrowed_at' => now(),
                'due_date' => $request->due_date
            ]);

            return response()->json(['success' => true, 'msg' => 'Empréstimo realizado com sucesso!', 'data' => $user->books], 201);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $post = ;

            return response()->json(['success' => true, 'data' => $post]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage], 400);
        }
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
        //
    }
}
