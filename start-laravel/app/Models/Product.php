<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ //esses sao os campos que vao poder ser malipulados na criação do PRODUTO
        'name',
        'price',
        'description',
        'enabled'
    ];

    public function scopeFindByName($query, $search){
        return $query->where(['name', 'LIKE', '%'. $search . '%']);

    }
}
