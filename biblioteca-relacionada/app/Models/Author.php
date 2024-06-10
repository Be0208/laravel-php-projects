<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name'
    ];

    //metodo para buscar os livros do author
    public function books(){
        return $this->hasMany(Book::class);
    }
}
