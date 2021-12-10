@extends('layouts.main', ['activePage' => 'terapeutas', 'titlePage' => 'Terapeutas'])
@section('content')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Terapeutas</h4>
                    <p class="card-category">Terapeutas registrados</p>
                  </div>
                  <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="success">
                      {{ session('success') }}
                    </div>
                    @endif
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
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th class="text-right">Acciones</th>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                            @foreach ($user->roles as $role)
                              @if ($role->id == PR_ROL_TERAPEUTA_ID)
                                <tr>
                                  <td>{{$user->id}}</td>
                                  <td>{{$user->name}}</td>
                                  <td>{{$user->apellidos}}</td>
                                  <td>{{$user->direccion}}</td>
                                  <td>{{$user->telefono}}</td>
                                  <td>{{$user->email}}</td>
                                  <td>
                                      @forelse ($user->roles as $role)
                                          <span class="badge badge-info">{{ $role->name }}</span>
                                      @empty
                                          <span class="badge badge-danger">Sin rol</span>
                                      @endforelse
                                  </td>
                                  <td class="td-actions text-right">
                                    @can('user_show') 
                                      <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                    @endcan
                                    @can('user_edit')
                                      <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                    @endcan 
                                    @can('user_destroy')
                                      <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                        @csrf
                                        @method('DELETE')
                                          <button class="btn btn-danger" type="submit" rel="tooltip">
                                          <i class="material-icons">close</i>
                                          </button>
                                      </form>
                                    @endcan 
                                  </td>
                                </tr>
                              @endif                              
                            @endforeach                              
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{-- {{ $users->links() }} --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection