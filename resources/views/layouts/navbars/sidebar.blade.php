<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://www.centroproyecta.es" class="simple-text logo-normal">
      <i><img style="width:200px" src="{{ asset('material') }}/img/LOGOazul.png"></i>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      
      @can('user_index')
       <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('users.index')}}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Usuarios') }}</p>
        </a>
      </li> 
      @endcan
      {{-- @can('permission_index')
      <li class="nav-item{{ $activePage == 'terapeutas' ? ' active' : '' }}">
       <a class="nav-link" href="{{route('terapeutas.index')}}">
         <i class="material-icons">loyalty</i>
           <p>{{ __('Terapeutas') }}</p>
       </a>
     </li> 
     @endcan --}}
      @can('permission_index')      
      <li class="nav-item{{ $activePage == 'permissions' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('permissions.index')}}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Permisos') }}</p>
        </a>
      </li>
      @endcan
      @can('role_index')
      <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('roles.index')}}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Roles') }}</p>
        </a>
      </li>
      @endcan
     
      @if ((auth()->user()->roles()->first()->id == PR_ROL_USUARIO_ID && auth()->user()->terapeuta_id != null) || auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID || auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)
        <li class="nav-item{{ $activePage == 'evento' ? ' active' : '' }}">
          <a class="nav-link" href="{{route('evento.index')}}">
            <i class="material-icons">today</i>
              <p>{{ __('Calendario') }}</p>
          </a>
        </li>
      @endif     
      @can('producto_index')
       <li class="nav-item{{ $activePage == 'productos' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('productos.index')}}">
          <i class="material-icons">shopping_bag</i>
          <p>{{ __('Productos') }}</p>
        </a>
      </li>
      @endcan
     
      <li class="nav-item{{ $activePage == 'tienda' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('tienda.index')}}">
          <i class="material-icons">shopping_cart</i>
          <p>{{ __('Tienda') }}</p>
        </a>
      </li> 
     
      @can('user_create')
      <li class="nav-item{{ $activePage == 'ventas' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('ventas.index')}}">
          <i class="material-icons">store</i>
          <p>{{ __('Ventas') }}</p>
        </a>
      </li>
      @endcan     
    </ul>
  </div>
</div>
