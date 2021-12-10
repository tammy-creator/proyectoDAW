@extends('layouts.main', ['activePage' => 'permissions', 'titlePage' => 'Permisos'])

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
                  <h4 class="card-title">Permisos</h4>
                  <p class="card-category">Permisos registrados</p>
                </div>
                <div class="card-body">                   
                  <div class="row">
                    <div class="col-12 text-right">
                    @can('permission_create')
                      <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">Añadir permiso</a>
                    @endcan
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>ID</th>
                        <th>Nombre</th>  
                        <th>Descripción</th>                         
                        <th class="text-right">Acciones</th>
                      </thead>
                      <tbody>
                        @forelse ($permissions as $permission)
                        <tr>
                          <td>{{ $permission->id }}</td>
                          <td>{{ $permission->name }}</td>
                          <td>{{ $permission->descripcion }}</td>                            
                          <td class="td-actions text-right">
                          @can('permission_show')  
                            <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-info"><i
                                class="material-icons">visibility</i></a>
                          @endcan
                          @can('permission_edit')  
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning"><i
                                class="material-icons">edit</i></a>
                          @endcan
                          @can('permission_destroy')                            
                            <button class="btn btn-danger modal_link" type="submit" rel="tooltip" data-id="{{$permission->id}}">
                              <i class="material-icons">close</i>
                            </button>  
                          @endcan
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="2">Sin registros.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer mr-auto">
                  {{ $permissions->links() }}
                </div>

                {{-- Modal Eliminar --}}
                <div id="confirm" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Eliminar Perfil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>¿Estas seguro de eliminar el permiso?</p>
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
              
              let permission_id = $(this).data('id-delete');
              
              let urlDelete = "{{url('permissions/:id')}}".replace(":id", permission_id);
              
              $.ajax(urlDelete, {
                method: 'delete',
                data: {
                  _token: "{{csrf_token()}}"
                }
              }).done(function(res) {
                $('#confirm').modal('hide');
                if(res['status'] === undefined) {
                  $('#error').text("Error interno borrando permiso").show();                  
                  return;
                }
                if(res.status == 1) {
                  $('#message').text(res.message).show();
                  $('#row-id-' + permission_id).remove()
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