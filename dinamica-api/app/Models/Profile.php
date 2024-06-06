<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'document',
        'nickname',
        'avatar',
        'resume',
        'user_id' //denomina que o profile pertence a um usuario (user_id)
    ];

    public function user(){
        return $this->belongsTo(User::class); //belongsTo = "pertence a alguem"
    }
}


