<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    //metodo para o livro pertencer a UM autor
    public function author(){
        return $this->belongsTo(Author::class);
    }
}
