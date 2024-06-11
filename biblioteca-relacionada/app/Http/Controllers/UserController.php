<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request -> validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);

            $user = User::create($request->all());

            return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!', 'data' => $user], 201);


        } catch (\Throwable $th) {
            
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
