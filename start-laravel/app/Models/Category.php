<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ //esses sao os campos que vao poder ser malipulados na criação do PRODUTO
        'name',
        'description',
        'enable'
    ];

    //delarar escopo em laravel

    public function scopeEnable($query) {
        return $query->where('enable', 1);
    }

    public function scopeNotEnable($query) {
        return $query->where('enable', 0);
    }

    public function scopeFindByName($query, $search) {
        return $query->where('name', 'LIKE', '%'. $search . '%');

        //like = buscar por algo que esta indefinido
    }
}
