<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;


class TerapeutaController extends Controller
{
    public function index(){
        
        
        $users = User::all();

        return view('terapeutas.index', compact('users'));
    }
}
