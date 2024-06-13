<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emprestimos = User::with('books')->get();
        return $emprestimos;
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


            $user->books()->attach($request->book_id, [
                'borrowed_at' =>  now(),
                'due_date' => $request->due_date
            ]);

            return response()->json(['success' => true, 'msg' => 'Emprestimo Realizado com sucesso!', 'data' => $user->books], 201);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $user_id, int $book_id)
    {
        try {
            $user = User::find($user_id);

            $book = $user->books()->where('book_id', $book_id)->firstOrFail();

            return $book;
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $user_id, int $book_id)
    {
        try {
            $request->validate([
                'due_date' => 'required|date'
            ]);

            $user = User::findOrFail($user_id);
            $user->books()->updateExistingPivot($book_id, [
                'due_date' => $request->due_date
            ]);

            return  $user->books()->where('book_id', $book_id)->first();
        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $user_id, int $book_id)
    {
        try {
            $user = User::findOrFail($user_id);
            $user->books()->detach($book_id);

            return 'Empréstimo removido com sucesso!';
        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }
}
