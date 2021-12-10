@extends('layouts.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      
      @if (auth()->user()->roles()->first()->id == PR_ROL_USUARIO_ID)   
        <div class="row justify-content-md-center">
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats">
              <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">person</i>
                </div>
                <p class="card-category">Bienvenido</p>
                <h3 class="card-title"><span>{{auth()->user()->name}}</span></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">face</i>
                  <a href="{{route('profile.edit')}}"> Ir a mi perfil... </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">store</i>
                </div>
                <p class="card-category">Horas bono</p>
                <h3 class="card-title"><span>{{$bonoHoras}}</span></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">store</i>
                  <a href="{{route('tienda.index')}}"> Comprar más... </a>
                </div>
              </div>
            </div>
          </div>
          @if (auth()->user()->terapeuta_id != null)
            <div class="col-lg-4 col-md-4 col-sm-4">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">pending_actions</i>
                  </div>
                  <p class="card-category">Próxima cita</p>
                  @if ($proxEvento == null)
                    <h3 class="card-title"><span> <strong>No tiene citas</strong>  </span></h3>
                  @else
                    <h3 class="card-title"><span> <strong>Día:</strong>  {{date("d-m", strtotime($proxEvento->fecha))}} a las {{date("h", strtotime($proxEvento->hora_inicio))}} h.</span></h3>
                  @endif
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i>
                    <a href="{{route('evento.index')}}"> Ver calendario </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif

      @if (auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)     
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">person</i>
                </div>
                <p class="card-category">Usuarios Registrados</p>
                <h3 class="card-title">
                  <span>{{$countUsers}}</span>
                </h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">content_paste</i>
                  <a href="{{route('users.index')}}">Saber más...</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">store</i>
                </div>
                <p class="card-category">Ventas Totales</p>
                <h3 class="card-title"><span>{{$totalVendido}} €</span></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">store</i>
                  <a href="{{route('ventas.index')}}"> Ver ventas... </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card card-stats">
              <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">pending_actions</i>
                </div>
                <p class="card-category">Citas Hoy</p>
                <h3 class="card-title"><span>{{$countEventos}}</span></h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">date_range</i>
                  <a href="{{route('evento.index')}}"> Ver calendario </a>
                </div>
              </div>
            </div>
          </div>          
        </div>
      @endif
      @if (auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)     
      <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">person</i>
              </div>
              <p class="card-category">Mis pacientes</p>
              <h3 class="card-title">
                <span>{{$countUserTerap}}</span>
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">content_paste</i>
                <a href="{{route('users.index')}}">Saber más...</a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">pending_actions</i>
              </div>
              <p class="card-category">Citas Hoy</p>
              <h3 class="card-title"><span>{{$countEventos}}</span></h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i>
                <a href="{{route('evento.index')}}"> Ver calendario </a>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    @endif
      {{-- <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Email Subscriptions</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Completed Tasks</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
      </div>--}}
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">Últimas Notificaciones:</span>
                  <ul class="nav nav-tabs justify-content-md-center" data-tabs="tabs">
                    <li class="nav-item ">
                      <a class="nav-link active" href="#eventos" data-toggle="tab">
                        <i class="material-icons">event</i> Nuevas Citas
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    @if (auth()->user()->roles()->first()->id != PR_ROL_USUARIO_ID)
                    <li class="nav-item">
                      <a class="nav-link" href="#usuarios" data-toggle="tab">
                        <i class="material-icons">face</i> Nuevos Usuarios
                        <div class="ripple-container"></div>
                      </a>
                    </li> 
                    @endif                   
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="eventos">
                  <table class="table">
                    <tbody>                
                      @foreach ($eventoNotifications as $item)
                        @if ($item->type == 'App\Notifications\EventoNotification')
                          <tr>
                            <td> <span class="badge badge-info">Nueva Cita:</span>  {{$item->data['user_name']}} para el día {{date("d-m-Y", strtotime($item->data['fecha']))}} a las {{$item->data['hora_inicio']}}</td>                  
                            
                        @endif
                      @endforeach 
                            <td class="td-actions text-right">
                              <a href="{{ route('markAsRead')}}" class="btn btn-info btn-link btn-sm">                          
                                <i class="material-icons">done_all</i> 
                                <span><strong> Marcar Leídos </strong></span> 
                              </a>
                            </td>
                          </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="usuarios">
                  <table class="table">
                    <tbody>
                        @foreach ($eventoNotifications as $item)
                          @if ($item->type == 'App\Notifications\UserNotification')
                          <tr>
                          <td>Nuevo usuario registrado: {{$item->data['user_name']}}</td>                  
                          @endif
                        @endforeach                        
                        <td class="td-actions text-right">
                          <a href="{{ route('markAsRead')}}" class="btn btn-info btn-link btn-sm">                          
                            <i class="material-icons">done_all</i> 
                            <span><strong> Marcar Leídos </strong></span> 
                          </a>
                        </td>  
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        @if (auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)   
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header card-header-warning">
                <h4 class="card-title">Terapeutas</h4>              
              </div>
              <div class="card-body table-responsive">
                <table class="table table-hover">
                  <thead class="text-warning">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Pacientes</th>
                  </thead>
                  <tbody>                  
                    @foreach ($users as $user)
                      @foreach ($user->roles as $role)
                        @if ($role->id == PR_ROL_TERAPEUTA_ID)
                          <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>                                                     
                            <td>{{$user->telefono}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$countUserTerap}}</td>
                          </tr>
                        @endif
                      @endforeach 
                    @endforeach         
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
        @if (auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header card-header-warning">
                <h4 class="card-title">Mis Pacientes</h4>              
              </div>
              <div class="card-body table-responsive">
                <table class="table table-hover">
                  <thead class="text-warning">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                  </thead>
                  <tbody>                  
                    @foreach ($users as $user)
                      @foreach ($user->roles as $role)
                        @if ($role->id == PR_ROL_USUARIO_ID && $user->terapeuta_id == auth()->user()->id)
                          <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>  
                            <td>{{$user->apellidos}}</td>                                                   
                            <td>{{$user->telefono}}</td>
                            <td>{{$user->email}}</td>                            
                          </tr>
                        @endif
                      @endforeach 
                    @endforeach         
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
        @if (auth()->user()->roles()->first()->id == PR_ROL_USUARIO_ID)
          <div class="col-sm-6" style="width: 50rem;">
            <div class="card">
              <div class="card-header card-header-warning">
                <h4 class="card-title">Mis Compras</h4>              
              </div>
              <div class="card-body table-responsive">
                <table class="table table-hover">
                  <thead class="text-warning">
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>                    
                  </thead>
                  <tbody>                  
                    @foreach ($ventas as $venta)
                      @if ($venta->user_id == auth()->user()->id)
                        <tr>
                          <td>{{date("d-m-Y", strtotime($venta->created_at))}}</td>
                          <td>{{$venta->producto_name}}</td>  
                          <td>{{$venta->precio}}</td>                                                   
                          <td>{{$venta->cantidad}}</td>
                        </tr>
                      @endif
                    @endforeach         
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div> 
  </div>
@endsection


