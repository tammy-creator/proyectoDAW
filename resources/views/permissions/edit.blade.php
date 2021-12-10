@extends('layouts.main', ['activePage' => 'permissions', 'titlePage' => __('Editar permiso')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('permissions.update', $permission->id)}}" class="form-horizontal">
            @csrf           
            @method('PUT')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Permiso') }}</h4>
                <p class="card-category">{{ __('Modificar permiso') }}</p>
              </div>

              <div class="card-body ">
                <div class="row">
                  <label for="name" class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="name" type="text" value="{{ old('name', $permission->name) }}" autofocus/>                      
                    @if ($errors->has('name'))
                      <span class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                    @endif                  
                  </div>
                </div> 
                <div class="row">
                  <label for="descripcion" class="col-sm-2 col-form-label">{{ __('Descripción') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="descripcion" type="text" value="{{ old('descripcion', $permission->descripcion) }}" autofocus/>                      
                                     
                  </div>
                </div>               

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Actualizar Permiso') }}</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-primary mr-3"> Volver </a>
              </div>
            </div>
          </form>
        </div>
      </div>      
    </div>
  </div>
@endsection