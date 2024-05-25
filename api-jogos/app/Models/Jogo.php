<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jogo extends Model
{
    protected $fillable = [
        'name',
        'storage',
        'score',
        'status'
    ];

    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }
}
