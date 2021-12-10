@extends('layouts.main', ['activePage' => 'productos', 'titlePage' => __('Editar producto')])

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
          <form method="post" action="{{route('productos.update', $producto->id)}}" class="form-horizontal">
            @csrf           
            @method('PUT')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Producto') }}</h4>
                <p class="card-category">{{ __('Modificar datos') }}</p>
              </div>

              <div class="card-body ">
                <div class="row">
                  <label for="name" class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="name" type="text" value="{{ old('name', $producto->name) }}" autofocus/>                      
                    @if ($errors->has('name'))
                      <span class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                    @endif                  
                  </div>
                </div>

                <div class="row">
                  <label for="precio" class="col-sm-2 col-form-label">{{ __('Precio') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="precio" type="text" value="{{ old('precio', $producto->precio) }}"/>                      
                    @if ($errors->has('precio'))
                      <span class="error text-danger" for="input-precio">{{ $errors->first('precio') }}</span>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <label for="descripcion" class="col-sm-2 col-form-label">{{ __('Descripción') }}</label>
                  <div class="col-sm-7">
                    <input class="form-control" rows="3" name="descripcion" type="text" value="{{ old('descripcion', $producto->descripcion) }}"/>                      
                    @if ($errors->has('descripcion'))
                      <span class="error text-danger" for="input-descripcion">{{ $errors->first('descripcion') }}</span>
                    @endif
                  </div>
                </div>

                <div class="fileinput fileinput-new">                  
                    <div class="col-sm-7 mt-3">
                        <label for="foto" class="col-sm-2 col-form-label">Imagen</label>
                        <input type="file" class="form-control-file hidden" name="foto" id="foto" accept="image/*">
                    </div>                
                </div> 

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Actualizar Producto') }}</button>
                <a href="{{ route('productos.index') }}" class="btn btn-primary mr-3"> Volver </a>
              </div>
            </div>
          </form>
        </div>
      </div>      
    </div>
  </div>
@endsection