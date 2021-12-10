@extends('layouts.main', ['activePage' => 'users', 'titlePage' => 'Detalles del usuario'])
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
                        <div class="card-title">Usuarios</div>
                        <p class="card-category">Vista detallada del usuario {{ $user->name }}</p>
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
                                            <img src="{{ asset('/material/img/default-avatar.png') }}" alt="image" class="avatar">
                                            <h5 class="title mt-3">{{ $user->name }}</h5>
                                            </a>
                                            <p class="description">                                   
                                            Apellidos: {{ $user->apellidos }} <br>
                                            Dirección: {{ $user->direccion }} <br>
                                            Teléfono: {{ $user->telefono }} <br>
                                            Email:{{ $user->email }} <br>  
                                            Rol:
                                            @forelse ($user->roles as $role)
                                            <span class="badge rounded-pill bg-dark text-white">{{ $role->name }}</span>
                                            @empty
                                            <span class="badge badge-danger bg-danger">No roles</span>
                                            @endforelse                                  
                                            
                                            </p>
                                        </div>
                                        </p>
                                        <div class="card-description">
                                        {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam officia corporis molestiae aliquid provident placeat. --}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        
                                        <div class="button-container">
                                            <a href="{{ route('users.index') }}" class="btn btn-primary mr-3"> Volver </a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Editar</a>
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
</div>
@endsection
                    