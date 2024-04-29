<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use HasFactory; //quando quero criar um criador de produtos
class Product extends Model
{
    protected $fillable = [ //esses sao os campos que vao poder ser malipulados na criação do PRODUTO
        'name',
        'price',
        'description',
        'enabled'
    ];
}
