<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//  php artisan make:model car --migration para criar a migration e a model juntos

class Car extends Model
{
    protected $fillable = [
        'marca',
        'modelo'
    ];


}
