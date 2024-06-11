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

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'book_user')->withPivot('borrowed_at', 'due_date');
    }

}
