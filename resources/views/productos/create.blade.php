@extends('layouts.main', ['activePage' => 'productos', 'titlePage' => __('Nuevo producto')])
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <form method="post" action="{{route('productos.store')}}" enctype="multipart/form-data" class="form-horizontal">
            @csrf         

            <div class="card ">

              @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li> {{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Producto') }}</h4>
                <p class="card-category">{{ __('Ingresar datos') }}</p>
              </div>

              <div class="card-body ">  
                <div class="form-group">
                    <div class="row">

                        <div class="col-sm-7">
                            <label for="name" class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                            <input class="form-control" name="name" type="text" required="true" value= "{{ old('name')}}" autofocus />                      
                        </div>
                        
                        <div class="col-sm-7">
                          <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                          <textarea class="form-control" name="descripcion" id="descripcion" rows="3" value="{{ old('descripcion')}}" required="true"></textarea>
                        </div> 
                      
                        <div class="col-sm-7 mt-3">
                          <label for="precio" class="col-sm-2 col-form-label">Precio</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                      <span class="material-icons">keyboard_alt</span>
                                  </span>
                              </div>
                              <input type="number" name="precio" id="precio" class="form-control" min="0,00" step=".01" placeholder="0.00"  value= "{{ old('precio')}}"/>
                            </div>
                        </div>
                    </div> 
                </div>
                 
                <div class="fileinput fileinput-new">                  
                  <div class="col-sm-7 mt-3">
                      <label for="foto" class="col-sm-2 col-form-label">Imagen</label>
                      <input type="file" class="form-control-file hidden" name="foto" id="foto" accept="image/*">
                  </div>                
                </div> 

              </div>
            <!--Footer-->
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{ route('productos.index') }}" class="btn btn-primary"> Volver </a>
            </div>
            <!--End footer-->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection