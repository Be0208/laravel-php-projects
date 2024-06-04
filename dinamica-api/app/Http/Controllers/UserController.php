<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $user = User::all();

        return response()->json(['success' => 'true', 'msg' => 'Usuários mostrados com sucesso', 'data' => $user]);
    }

  
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'required' => 'O campo :attribute é obrigatório!'
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['success' => 'true', 'msg' => 'Usuários cadastrados com sucesso', 'data' => $user]);


        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

   
    public function show(string $id)
    {
        try {

            return response()->json(['success' => 'true', 'msg' => 'Usuário encontrado com sucesso', 'data' => User::findOrFail($id)]);

        } catch (\Throwable $th) {

            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $user = User::findOrFail($id);

            if($request->has('name')){
                $user->name = $request->name;
            }
            if($request->has('email')){
                $user->email = $request->email;
            }
            if($request->has('password')){
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json(['success' => 'true', 'msg' => 'Usuário alterado com sucesso', 'data' => $user]);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

 
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['success' => 'true', 'msg' => 'Usuário deletado com sucesso', 'data' => $user]);

        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }

    }
}
