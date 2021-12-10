<?php

use Illuminate\Support\Facades\Route;
use App\Mail\AvisoCitaMailable;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');
   
    Route::resource('permissions', App\Http\Controllers\PermissionController::class );

    Route::resource('roles', App\Http\Controllers\RoleController::class );

    Route::get('/evento', [App\Http\Controllers\EventoController::class, 'index'])->name('evento.index');
    Route::post('/evento/agregar', [App\Http\Controllers\EventoController::class, 'store'])->name('evento.store');
    Route::get('/evento/show', [App\Http\Controllers\EventoController::class, 'show'])->name('evento.show');
    Route::delete('/evento/delete/{id}', [App\Http\Controllers\EventoController::class, 'destroy'])->name('evento.delete');
    Route::get('/evento/showTherapistBookings', [App\Http\Controllers\EventoController::class, 'showTherapistBookings'])->name('evento.showTherapistBookings');

    Route::get('/terapeutas', [App\Http\Controllers\TerapeutaController::class, 'index'])->name('terapeutas.index');

    Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.edit');
    Route::get('/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'show'])->name('productos.show');
    Route::put('/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.delete');

    Route::get('/tienda', [App\Http\Controllers\ProductoController::class, 'indexTienda'])->name('tienda.index');
    Route::get('/tienda/carrito', [App\Http\Controllers\ProductoController::class, 'carrito'])->name('tienda.carrito');
    Route::get('/tienda/{id}', [App\Http\Controllers\ProductoController::class, 'addCarrito'])->name('tienda.addCarrito');
    Route::get('/tienda/carritoCambio/{id}/{quant}', [App\Http\Controllers\ProductoController::class, 'changeQuantity'])->name('tienda.changeQuantity');
    Route::delete('/tienda', [App\Http\Controllers\ProductoController::class, 'removeCart'])->name('tienda.remove');
    
    Route::get('/ventas', [App\Http\Controllers\VentasController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [App\Http\Controllers\VentasController::class, 'store'])->name('ventas.store');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [App\Http\Controllers\VentasController::class, 'password'])->name('profile.password');

    Route::get('markAsRead', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');
});

