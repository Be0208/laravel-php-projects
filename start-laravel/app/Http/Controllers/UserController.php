<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function create(Request $request){
        $data = $request->json()->all();

        Cache::add('user', json_encode($data));

        return response()->json(['success' => true, 'msg' => "Usuário salvo com sucesso!"]);
    }
}
