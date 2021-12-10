@extends('layouts.main', ['activePage' => 'permissions', 'titlePage' => __('Nuevo permiso')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('permissions.store')}}" class="form-horizontal">
            @csrf           

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Permiso') }}</h4>
                <p class="card-category">{{ __('Ingresar datos') }}</p>
              </div>

              <div class="card-body ">               
                <div class="row">
                  <label for="name" class="col-sm-2 col-form-label">{{ __('Nombre Permiso') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="name" type="text" placeholder="{{ __('Nombre') }}" required="true" autofocus />                      
                    @if ($errors->has('name'))
                      <span class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <label for="descripcion" class="col-sm-2 col-form-label">{{ __('Descripción Permiso') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="descripcion" type="text" placeholder="{{ __('Descripción') }}" required="true" autofocus />                      
                    
                  </div>
                </div>                              

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Guardar Permiso') }}</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-primary mr-3"> Volver </a>
              </div>
            </div>
          </form>
        </div>
      </div>      
    </div>
  </div>
@endsection

