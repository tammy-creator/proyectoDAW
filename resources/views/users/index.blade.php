@extends('layouts.main', ['activePage' => 'users', 'titlePage' => 'Usuarios'])
@section('content')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

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
                    <h4 class="card-title">Usuarios</h4>
                    <p class="card-category">Usuarios registrados</p>
                  </div>
                  
                    <div class="row">
                      <div class="col-12 text-right">
                      @can('user_create')
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Añadir usuario</a>
                      @endcan 
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                          @if(auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th class="text-right">Acciones</th>
                          @else
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>                           
                            <th>Rol</th> 
                            <th>Terapeuta</th>
                            <th class="text-right">Acciones</th>
                          @endif
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                            <tr id="row-id-{{$user->id}}">
                              @if(auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)
                                @if (auth()->user()->id == $user->terapeuta_id)
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->apellidos}}</td>
                                <td>{{$user->direccion}}</td>
                                <td>{{$user->telefono}}</td>
                                <td>{{$user->email}}</td>
                                <td class="td-actions text-right">
                                  @can('user_show') 
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                  @endcan
                                  @can('user_edit')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                  @endcan 
                                  @can('user_destroy')
                                    <button class="btn btn-danger modal_link" type="submit" rel="tooltip" data-id="{{$user->id}}">
                                      <i class="material-icons">close</i>
                                    </button>
                                  @endcan 
                                  </td>
                                @endif
                              @else
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->apellidos}}</td>
                                <td>
                                    @forelse ($user->roles as $role)
                                        <span class="badge badge-info">{{ $role->name }}</span>
                                    @empty
                                        <span class="badge badge-danger">Sin rol</span>
                                    @endforelse
                                </td>
                                <td>{{$user->terapeuta}}</td>
                                <td class="td-actions text-right">
                                @can('user_show') 
                                  <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i class="material-icons">visibility</i></a>
                                @endcan
                                @can('user_edit')
                                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                @endcan 
                                @can('user_destroy')                                  
                                  <button class="btn btn-danger modal_link" type="submit" rel="tooltip" data-id="{{$user->id}}">
                                  <i class="material-icons">close</i>
                                  </button>                                  
                                @endcan 
                                </td>
                              @endif 
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{ $users->links() }} 
                  </div>
                  {{-- Modal Eliminar --}}
                  <div id="confirm" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Eliminar Usuario</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>¿Estas seguro de eliminar al usuario?</p>
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
              
              let user_id = $(this).data('id-delete');
              if(!$.isNumeric(user_id)) {
                console.error("Error, no se puede enviar un delete a un id vacio");
                return;
              }
              let urlDelete = "{{url('users/:id')}}".replace(":id", user_id);
              console.log("Vamos a llamar a", urlDelete);
              $.ajax(urlDelete, {
                method: 'delete',
                data: {
                  _token: "{{csrf_token()}}"
                }
              }).done(function(res) {
                $('#confirm').modal('hide');
                if(res['status'] === undefined) {
                  $('#error').text("Error interno borrando usuario").show();
                  
                  return;
                }
                if(res.status == 1) {
                  $('#message').text(res.message).show();
                  $('#row-id-' + user_id).remove()
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