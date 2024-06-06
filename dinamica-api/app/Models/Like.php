<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'userId',
        'postId'
    ];

    public function post(){
        return $this->belongsTo(Post::class, 'postId'); //belongsTo = "pertence a alguem"
    }
    public function user(){
        return $this->belongsTo(User::class, 'userId'); //belongsTo = "pertence a alguem"
    }

}
