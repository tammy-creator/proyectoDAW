@extends('layouts.main', ['activePage' => 'productos', 'titlePage' => 'Detalles del producto'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    @if (session('success'))
                        <div class="alert alert-success" role="success">
                        {{ session('success') }}
                        </div>
                    @endif

                    <div class="card-header card-header-primary">
                        <div class="card-title">Productos</div>
                        <p class="card-category">Vista detallada del producto {{ $producto->name }}</p>
                    </div>
                    <!--body-->
                    <div class="card-body">                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="card card-user">
                            <div class="card-body">
                                <p class="card-text">
                                <div class="author">
                                    <a href="#">
                                    <img src="{{$producto->imageSrc}}" alt="image" class="avatar">
                                    <h5 class="title mt-3">{{ $producto->name }}</h5>
                                    </a>
                                    <p class="description">                                   
                                    Precio: {{ $producto->precio }} € <br>                                   
                                    </p>
                                </div>
                                </p>
                                <div class="card-description">
                                    Descripción: {{ $producto->descripcion }} <br>
                                </div>
                            </div>
                            <div class="card-footer">
                                
                                <div class="button-container">
                                    <a href="{{ route('productos.index') }}" class="btn btn-primary mr-3"> Volver </a>
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary">Editar</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
                    