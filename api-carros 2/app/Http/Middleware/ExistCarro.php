<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CacheService;
use Symfony\Component\HttpFoundation\Response;

class ExistCarro
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $carros = CacheService::getCarros();
        $carro = $carros->firstWhere('id', $request->route()->id);

        if($carro == null){
            return response()->json(['success' => false, 'msg' => "carro não encontrado."], 404);
        }




         $request->attributes->add(['carro' => $carro]);
         $request->attributes->add(['carros' => $carros]);




        return $next($request);
    }
}
