<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    static $rules=[
        'user_id'=> 'required|exists:users,id', 
        'terapeuta_id' =>'required|exists:users,id',
        'fecha'=> 'required',
        'hora_inicio'=> 'required',
        'hora_final'=> 'required',          
    ];

    protected $fillable=[
        'user_id',
        'terapeuta_id',        
        'fecha',
        'hora_inicio',
        'hora_final',         
    ];
}
