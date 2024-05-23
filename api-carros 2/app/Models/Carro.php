<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $fillable = [
        'marca',
        'modelo',
        'status'
    ];

    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }


}
