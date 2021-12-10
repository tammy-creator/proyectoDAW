<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;

class VentasController extends Controller
{
    public function index(){        
        abort_if(Gate::denies('producto_index'), 403);
        
        $cart = session()->get("cart");
        $user = auth()->user();
        
        $ventas = Venta:: paginate(8);
        $users = User::all();
            
        return view('ventas.index', compact('ventas','cart','user', 'users'));
    }

    public function store(Request $request)
    {
        $cart = session()->get("cart");
        $user = auth()->user();
        
        $ventas = [];
        foreach($cart as $value){
            $ventas[] = [
                "user_id"=>$user->id,
                "producto_id"=>$value['id_producto'],
                "producto_name"=>$value['name'],
                "precio"=>$value['precio'],
                "cantidad"=>$value['cantidad'],
            ];
        }
        
        foreach($ventas as $value){
            $venta=Venta::create($value);            
        };

       session()->put('cart', null);
        return response()->json([
            'status' => 1,
            'message' => 'Compra realizada correctamente',
        ]);
        
    }

}
