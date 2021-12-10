@extends('layouts.main', ['activePage' => 'permissions', 'titlePage' => 'Detalles del permiso'])
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
                        <div class="card-title">Permisos</div>
                        <p class="card-category">Vista detallada del permiso {{ $permission->name }}</p>
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
                                    <img src="{{ asset('/material/img/astronauta.jpg') }}" alt="image" class="avatar">
                                    <h5 class="title mt-3">{{ $permission->name }}</h5>
                                    </a>                                    
                                </div>
                                </p>
                                <div class="card-description">
                                {{ $permission->descripcion }}
                                </div>
                            </div>
                            <div class="card-footer">                                
                                <div class="button-container">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-primary mr-3"> Volver </a>
                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary">Editar</a>
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
                    