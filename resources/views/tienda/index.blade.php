<?php session_start();?>
@extends('layouts.main', ['activePage' => 'tienda', 'titlePage' => 'Tienda'])
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
                    <h4 class="card-title">Tienda</h4>
                    <p class="card-category">Comprar productos</p>
                  </div>
                  <div class="card-body">                   

                    {{-- Productos --}}
                    <div class="container mt-5">
                        <div class="row" style="justify-content;">

                            @foreach ($productos as $producto)
                        
                            <div class="card m-4" style="width: 10rem;">
                                <form id="formulario" name="formulario" method="post" action="cart.php">
                                    <input name="precio" type="hidden" id="precio" value="{{$producto->precio}}" />
                                    <input name="name" type="hidden" id="name" value="{{$producto->name}}" />
                                    <input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2" />                                    
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><strong>  {{$producto->name}} </strong></h5>
                                        <img src="{{$producto->imageSrc}}" class="card-img-top" alt="imagen producto" width="10">
                                        <p class="card-text">{{$producto->descripcion}} </p>
                                        <p class="card-text">Precio: {{$producto->precio}}</p>
                                        <a href="{{ route('tienda.addCarrito', $producto->id) }}" class="btn btn-primary"><i class="material-icons">shopping_cart</i> Comprar</a>
                                    </div>
                                    
                                </form>
                            </div>

                            @endforeach
                
                        </div>
                    </div>
                  <div class="card-footer mr-auto">
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

   
@endsection
