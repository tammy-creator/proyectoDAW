<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class ProductoController extends Controller
{
    public function index(){        
        abort_if(Gate::denies('producto_index'), 403);
        
        $productos = Producto:: paginate(8);
        foreach($productos as $producto) {
            $fileImage = storage_path("app/" . $producto->foto);
            if (file_exists($fileImage)) {
                $producto->imageSrc = prGenerateSrcImageData($fileImage);
            }
            else {
                $fileImage = public_path("img/notFound.png");
                $producto->imageSrc = prGenerateSrcImageData($fileImage);
            }
        }
        
        return view('productos.index', compact('productos'));
    }

    public function indexTienda(Producto $producto){

        $productos = Producto:: all();
        foreach($productos as $producto) {
            $fileImage = storage_path("app/" . $producto->foto);
            if (file_exists($fileImage)) {
                $producto->imageSrc = prGenerateSrcImageData($fileImage);
            }
            else {
                $fileImage = public_path("img/notFound.png");
                $producto->imageSrc = prGenerateSrcImageData($fileImage);
            }
        }
        
        return view('tienda.index',compact('productos'));
    }

    public function carrito(){
        return view ('modal_cart');       
    }

    public function addCarrito($id){
        
        $producto = Producto::find($id);
        
        $cart = session()->get("cart");
        
        if(!$cart){
            $cart = [
                $id => [
                    "id_producto" => $producto->id,
                    "name" => $producto->name,
                    "cantidad" => 1,
                    "precio" => $producto->precio,
                    "foto" =>prGenerateSrcImageData(storage_path("app/" . $producto->foto)),
                 ]
            ];
           
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Producto añadido correctamente');
        }
        if(isset($cart[$id])){
            $cart[$id]['cantidad']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Producto añadido correctamente');

        }

        $cart[$id] = [
            "id_producto" => $producto->id,
            "name" => $producto->name,
            "cantidad" => 1,
            "precio" => $producto->precio,
            "foto" => prGenerateSrcImageData(storage_path("app/" . $producto->foto)),
        ];
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto añadido correctamente');

    }

    public function changeQuantity($id, $cantidad){
        $cart = session()->get('cart');
        if($cart[$id]['cantidad'] + $cantidad == 0) {
            unset($cart[$id]);
            $cantidad = 0;
            $newPrice = 0;
        }
        else {
            $cart[$id]['cantidad'] = $cantidad;
            $newPrice = $cart[$id]['cantidad']*$cart[$id]['precio'];
        }
        $total = 0;
        foreach($cart as $item) {
            $total = $item['cantidad']*$item['precio'];
        }
        session()->put('cart', $cart);
        return response()->json(['status'=> 0, 'newQuantity' => (int)$cantidad, 'newPrice' => $newPrice, "total" => $total]);
    }

    public function removeCart(){
        
        session(["cart" => null]);
        
        return response()->json([
            'status' => 1,
            'message' => 'Carrito vaciado correctamente',]);
        
    }

    public function create(){
        abort_if(Gate::denies('producto_create'), 403);
        
        return view('productos.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'name'=>'required|max:20',
            'descripcion'=>'required|min:3|max:200',
            'foto'=>'required|image|max:1024',
            'precio'=>'required',        
        ]);

       $producto = (new Producto)->fill($request->all());

        $producto->foto = $request->file('foto')->store('public/imagenesProductos');
        
        $producto->save();

        return redirect()->route('productos.index', $producto->id)->with('success','Producto creado correctamente');
    }

    public function show(Producto $producto){

        abort_if(Gate::denies('producto_show'), 403);

        $productos = Producto:: all();
        foreach($productos as $producto) {
            $fileImage = storage_path("app/" . $producto->foto);
            if (file_exists($fileImage)) {
                $producto->imageSrc = prGenerateSrcImageData($fileImage);
            }
            else {
                $fileImage = public_path("img/notFound.png");
                $producto->imageSrc = prGenerateSrcImageData($fileImage);
            }
        }
        
        return view('productos.show',compact('producto'));
    }    

    public function edit(Request $request, Producto $producto){
        
        abort_if(Gate::denies('producto_edit'), 403);
        
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($request->all());     

        return redirect()->route('productos.index')->with('success','Producto actualizado correctamente');

    }

    public function destroy(Producto $producto){

        abort_if(Gate::denies('producto_destroy'), 403);
        
        $producto->delete();

        return prResponseJson('Producto eliminado correctamente', 1);
    }
}
