<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    static public function  getCarros() {
        $carrosCache = Cache::get('carros');
        $carrosCollect = collect([]);

        if($carrosCache !== null){
            $carrosCollect = collect(json_decode($carrosCache));
        }

        return $carrosCollect;
    }

    static public function updateCarros($carros){
        Cache::put('carros', $carros->toJson());
    }

}
