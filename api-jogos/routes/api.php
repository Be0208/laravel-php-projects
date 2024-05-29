<?php

use App\Http\Controllers\JogoController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::resource('/users', UserController::class);

Route::post('/login', function (Request $request){
    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)){
        return response()->json(['success' => false, 'msg' => 'Verificar email ou senha.'], 401);
    };

    $token = $user->createToken($user->name, ['*'], now()->addMinutes(5))->plainTextToken;

    return response()->json(['success' => true, 'msg' => "Login efetuado com sucesso", 'data' => [
        'user' => $user,
        'token' => $token
    ]], 200);
});

Route::resource('/jogos', JogoController::class)->middleware('auth:sanctum');
