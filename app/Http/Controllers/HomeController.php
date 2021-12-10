<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Evento;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countEventos = DB::table('eventos')
        ->where('fecha',DB::raw('CURDATE()'))
        ->count();

        $proxEvento = DB::table('eventos')
        ->where('fecha','>=',DB::raw('CURDATE()'))
        ->where('user_id','=',auth()->user()->id)
        ->first();
                
        $countUsers = DB::table('users')->count();
       
        $ventas = Venta::all();
        
        $totalVendido = 0;
        $ldate = Carbon::now()->toDateTimeString();
       
        foreach ($ventas as $venta) {            
                    
                $eurosVenta = $venta->precio * $venta->cantidad;
                $totalVendido+=$eurosVenta; 
                
        }

        $eventoNotifications = auth()->user()->unreadNotifications;
        $users = User:: all(); 
        
        $countUserTerap = 0;
        foreach ($users as $user) {
            foreach ($user->roles as $role)
                if ($role->id == PR_ROL_TERAPEUTA_ID){
                $countUserTerap = DB::table('users')
                ->where('terapeuta_id',$user->id)
                ->count();
            }
        }
        $bonoHoras = 0;
        foreach ($ventas as $venta) {
            if ($venta->user_id == auth()->user()->id) {               
                if ($venta->producto_id == 1) {
                   $bonoHoras += 5;
                }elseif($venta->producto_id == 2){
                   $bonoHoras += 10;
                }
            }
        }; 
        $eventos = Evento:: all();
        foreach ($eventos as $evento) {
            if ($evento->user_id == auth()->user()->id) {                
               $bonoHoras-= 1;
            }
        }; 
                
       

        return view('home', compact('countUsers','countEventos','totalVendido','eventoNotifications','users','countUserTerap','ventas','bonoHoras','proxEvento'));
    }
}
