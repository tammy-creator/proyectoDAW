<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    
    protected $fillable=[
         
        'user_id',
        'producto_id',
        'producto_name',
        'precio',
        'cantidad'      
    ];
    
}
