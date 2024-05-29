<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ExistCarro;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;

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


// Route::post('/carros', function(Request $request){


//     if(!$request->has(['id','modelo', 'marca'])){
//       return response()->json(['error' => "Campos obrigatórios ausentes"]);
//     }

//    $carros = json_decode(Cache::get('carros'));

//    $carro = $request->json()->all();
//    $carros[] = $carro;


//    Cache::put('carros', json_encode($carros));

//     return response()->json(['success' => true, 'mgs' => "Carro adicionado com sucesso!"]);

//  });




// Route::get('/carros/get', function(){

//     $carros = Cache::get('carros');

//     return response()->json(['carros' => json_decode($carros) ]);

// });


// Route::get('/carros/{id}', function($id){

//     $carros = json_decode(Cache::get('carros'), true);


//     foreach($carros as $carro){
//         if($carro['id']  == $id){
//             return response()->json(['carro' => $carro]);
//         }
//     }


//     return response()->json(['error' => 'carro não encontrado!' ]);

// });




// Route::delete('/carros/{id}', function($id){

//     $carros = json_decode(Cache::get('carros'), true);


//     foreach ($carros as $key => $carro) {
//         if ($carro['id'] == $id) {
//             array_splice($carros, $key, 1);
//             Cache::put('carros', json_encode($carros));

//         }
//     }
//     return response()->json(['success' => true, 'mgs' => "Carro excluido!"]);

// });
Route::resource('/users', UserController::class);


Route::post('/login', function(Request $request){

    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)){ //metodo check vai pegar o valor criptografado e ver se lea bate com o valor cripto do user
        return response()->json(['success' => false, 'msg' => 'Verificar email ou senha.'], 401);
    };

    $token = $user->createToken($user->email, ['*'], now()->addHour())->plainTextToken;

    return response()->json(['success' => true, 'msg' => "Login efetuado com sucesso", 'data' => [
        'user' => $user,
        'token' => $token
    ]], 200);
});


Route::resource('/carros', CarroController::class)->middleware('auth:sanctum');
// Route::get('/carros/{id}', [CarroController::class, 'show'])->middleware(ExistCarro::class);
