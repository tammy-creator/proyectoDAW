@extends('layouts.main', ['activePage' => 'ventas', 'titlePage' => 'Productos Vendidos'])
@section('content')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">

                  @if (session('success'))
                  <div class="alert alert-success" role="success">
                    {{ session('success') }}
                  </div>
                  @endif
                  @if (session('error'))
                  <div class="alert alert-danger" role="danger">
                    {{ session('error') }}
                  </div>
                  @endif
                  
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Productos</h4>
                    <p class="card-category">Productos vendidos</p>
                  </div>
                  <div class="card-body">                   
                    
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                          
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Fecha compra</th>
                            <th>Producto</th>                            
                            <th>Precio</th> 
                            <th>Cantidad</th>   
                            <th>Ingreso Total</th>                        
                        </thead>
                        <tbody>
                          @foreach ($ventas as $venta)
                            @foreach ($users as $user)  
                              @if (auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)
                                @if ($venta->user_id == $user->id)                               
                                <tr>
                                  <td>{{$venta->id}}</td>
                                  <td>{{$user->name}}</td>
                                  <td>{{$venta->created_at->diffForHumans()}}</td>
                                  <td>{{$venta->producto_name}}</td>
                                  <td>{{$venta->precio}}</td>  
                                  <td>{{$venta->cantidad}}</td>  
                                  <td>{{$venta->precio * $venta->cantidad}} €</td>                                 
                                </tr>
                                @endif
                              @endif
                              @if(auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)
                                @if ($venta->user_id == $user->id && auth()->user()->id == $user->terapeuta_id) 
                                  <tr>
                                    <td>{{$venta->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$venta->created_at->diffForHumans()}}</td>
                                    <td>{{$venta->producto_name}}</td>
                                    <td>{{$venta->precio}}</td>  
                                    <td>{{$venta->cantidad}}</td>  
                                    <td>{{$venta->precio * $venta->cantidad}} €</td>                                 
                                  </tr>
                                @endif
                              @endif
                            @endforeach
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{ $ventas->links() }} 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection