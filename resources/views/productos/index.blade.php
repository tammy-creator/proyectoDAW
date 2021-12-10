@extends('layouts.main', ['activePage' => 'productos', 'titlePage' => 'Productos'])
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

                  <div class="alert alert-danger" id="error" style="display:none"></div>
                  <div class="alert alert-success" id="message" style="display:none"></div>

                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Productos</h4>
                    <p class="card-category">Productos registrados</p>
                  </div>
                  <div class="card-body">
                    @can('producto_create')
                    <div class="row">
                      <div class="col-12 text-right">
                        <a href="{{ route('productos.create') }}" class="btn btn-sm btn-primary">Añadir producto</a>
                      </div>
                    </div>
                    @endcan
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>                            
                            <th>Precio</th>                           
                            <th class="text-right">Acciones</th>
                        </thead>
                        <tbody>
                          @foreach ($productos as $producto)
                            <tr>
                                <td>{{$producto->id}}</td>
                                <td><img width="50" src="{{$producto->imageSrc}}" alt="imagen producto" /></td>
                                <td>{{$producto->name}}</td>
                                <td>{{$producto->descripcion}}</td>
                                <td>{{$producto->precio}}</td>                                                               
                              
                                <td class="td-actions text-right">
                                @can('producto_show') 
                                  <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info"><i class="material-icons">visibility</i></a>
                                @endcan
                                @can('producto_edit')
                                  <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                @endcan 
                                @can('producto_destroy')
                                  <button class="btn btn-danger modal_link" type="submit" rel="tooltip" data-id="{{$producto->id}}">
                                    <i class="material-icons">close</i>
                                  </button>
                                @endcan 
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{ $productos->links() }} 
                  </div>

                  {{-- Modal Eliminar --}}
                  <div id="confirm" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Eliminar Producto</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>¿Estas seguro de eliminar el producto?</p>
                        </div>
                        <div class="modal-footer">
                          <button id="btnConfirm" type="button" class="btn btn-primary">Eliminar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancelar</button>
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
@section('bottomJs')
<script>
  $(document).on('click',".modal_link",function(){
    $('#error').text('').hide();
    $('#message').text('').hide();
    $("#confirm").modal('show');
    $('#btnConfirm').data('id-delete', $(this).data('id'));
  });
    $(document).on('click',"#btnConfirm",function(){                
              
              let producto_id = $(this).data('id-delete');
              
              let urlDelete = "{{url('productos/:id')}}".replace(":id", producto_id);
              
              $.ajax(urlDelete, {
                method: 'delete',
                data: {
                  _token: "{{csrf_token()}}"
                }
              }).done(function(res) {
                $('#confirm').modal('hide');
                if(res['status'] === undefined) {
                  $('#error').text("Error interno borrando producto").show();
                  
                  return;
                }
                if(res.status == 1) {
                  $('#message').text(res.message).show();
                  $('#row-id-' + producto_id).remove()
                }
                else {
                  $('#error').text(res.message).show();
                }
               
              }).fail(function(xhr) {
                console.error(xhr);
              });
    });
</script>
@endsection
