@extends('layouts.main', ['activePage' => 'users', 'titlePage' => __('Editar usuario')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <form method="post" action="{{route('users.update', $user->id)}}" class="form-horizontal">
            @csrf           
            @method('PUT')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Usuario') }}</h4>
                <p class="card-category">{{ __('Modificar datos') }}</p>
              </div>

              <div class="card-body ">
                <div class="row">
                  <label for="name" class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}" autofocus/>                      
                    @if ($errors->has('name'))
                      <span class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                    @endif                  
                  </div>
                </div>

                <div class="row">
                  <label for="apellidos" class="col-sm-2 col-form-label">{{ __('Apellidos') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="apellidos" type="text" value="{{ old('apellidos', $user->apellidos) }}"/>                      
                    @if ($errors->has('apellidos'))
                      <span class="error text-danger" for="input-apellidos">{{ $errors->first('apellidos') }}</span>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <label for="direccion" class="col-sm-2 col-form-label">{{ __('Dirección') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="direccion" type="text" value="{{ old('direccion', $user->direccion) }}"/>                      
                    @if ($errors->has('direccion'))
                      <span class="error text-danger" for="input-direccion">{{ $errors->first('direccion') }}</span>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <label for="telefono" class="col-sm-2 col-form-label">{{ __('Teléfono') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="telefono" type="text" value="{{ old('telefono',$user->telefono) }}"/>                      
                    @if ($errors->has('telefono'))
                      <span class="error text-danger" for="input-telefono">{{ $errors->first('telefono') }}</span>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <input type="mail" class="form-control" name="email"  value="{{ old('email', $user->email) }}"/>                      
                    @if ($errors->has('email'))
                      <span class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                  <div class="col-sm-7">
                    <input type="password" class="form-control" name="password" placeholder="Ingrese la contraseña solo en caso de querer modificarla" />                      
                    @if ($errors->has('password'))
                      <span class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <label for="role" class="col-sm-2 col-form-label">{{ __('Rol') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">                 
                      <select class="form-control " data-style="btn btn-link" id="role_id" name="role_id">
                        <option value="">Asignar Rol al usuario</option>
                        @foreach ($roles as $id => $role)
                          {{ $selected =  $user->roles->contains($id) ? ' selected' : ''}}
                          <option value="{{ $id }}"{{$selected}}>{{ $role }}</option>                          
                        @endforeach             
                      </select>
                   </div>
                  </div>
                </div>

                <div class="row">
                  <label for="terapeuta" class="col-sm-2 col-form-label">{{ __('Terapeuta') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">                
                      <select class="form-control " data-style="btn btn-link" id="terapeuta_id" name="terapeuta_id">
                        <option value="">Asignar Terapeuta al usuario</option>
                          @foreach ($terapeutas as $terapeuta)  
                            {{ $selected =  ($user->terapeuta_id == $terapeuta->id) ? ' selected' : ''}}                                            
                            <option value="{{ $terapeuta->id }}"{{$selected}}>{{ $terapeuta->name }}</option>                                                
                          @endforeach               
                      </select>
                   </div>
                  </div>
                </div>

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Actualizar Usuario') }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-primary mr-3"> Volver </a>
              </div>
            </div>
          </form>
        </div>
      </div>      
    </div>
  </div>
@endsection