<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#"></a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsingNavbar" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="collapsingNavbar" >
      {{-- <form class="navbar-form">
        <div class="input-group no-border">
        <input type="text" value="" class="form-control" placeholder="Search...">
        <button type="submit" class="btn btn-white btn-round btn-just-icon">
          <i class="material-icons">search</i>
          <div class="ripple-container"></div>
        </button>
        </div>
      </form> --}}
      
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}">
                <i class="material-icons">dashboard</i>
                <p class="d-lg-none d-md-block">
                  {{ __('Stats') }}
                </p>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">notifications</i>
                
                  @if (count(auth()->user()->unreadNotifications))
                    <span class="notification">
                     {{count(auth()->user()->unreadNotifications)}}
                    </span>                    
                  @endif
                
                <p class="d-lg-none d-md-block">
                  {{ __('Some Actions') }}
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                @foreach (auth()->user()->unreadNotifications as $notification)
                  @if ($notification->type == 'App\Notifications\EventoNotification')
                    <a class="dropdown-item" href="{{route('evento.index')}}">
                      <i class="mr-2">Nueva Cita: {{ $notification->data['user_name'] }}</i>
                      <span class="pull-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                  @else
                    <a class="dropdown-item" href="{{route('users.index')}}">
                      <i class="mr-2">Nuevo usuario registrado {{ $notification->data['user_name'] }}</i>
                      <span class="pull-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                  @endif
                @endforeach                
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" id="modal_cart_link" href="#modal_cart" data-bs-toggle="modal" data-bs-target="#modal_cart">
                <i class="material-icons"> shopping_cart</i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">person</i>
                <p class="d-lg-none d-md-block">
                  {{ __('Account') }}
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Mi Perfil') }}</a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Salir') }}</a>
              </div>
            </li>
          </ul>
       
    </div>
  </div>
</nav>

 <!-- MODAL CARRITO -->
 <div class="modal fade bd-example-modal-lg" id="modal_cart" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Carrito Compra</h5>
      </div>
      <div class="modal-body">

        <?php $valor = 0 ?>

        @if (session('cart'))

        <div class="table-responsive">
          <table class="table table-shopping">
            <thead class="text-primary">
              <tr>
                <th class="text-center"></th>
                <th class="hide"></th>
                <th class="text-center">Producto</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio Total</th>
                <th></th>
              </tr>              
            </thead>
            <tbody>
              
              @foreach (session('cart') as $id=>$detalles)              
                @php
                  $valor += $detalles['precio'] * $detalles['cantidad']
                @endphp
                    <tr class="text-center" scope="row" id="rowItem-{{$id}}" >
                      <td>
                        <div class="img-container">
                          <img src="{{$detalles['foto']}}" class="card-img-top w-25" alt="imagen producto">
                        </div>
                      </td> 
                      <td class="hide">{{$id}}</td>        
                      <td class="text-center">{{$detalles['name']}}</td>
                      <td class="text-center">{{$detalles['precio']}}</td>
                      <td class="text-center" id="quantity-{{$id}}" data-quantity="{{$detalles['cantidad']}}">{{$detalles['cantidad']}}</td>
                      <td class="text-center" id="price-{{$id}}" data-value="{{$detalles['precio'] * $detalles['cantidad'] }}">{{$detalles['precio'] * $detalles['cantidad'] }} </td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-round btn-primary btn-sm removeItem" data-id="{{$id}}"> <i class="material-icons">remove</i> </button>
                          <button class="btn btn-round btn-primary btn-sm addItem" data-id="{{$id}}"> <i class="material-icons">add</i> </button>
                        </div>
                      </td>
                    </tr>
              @endforeach
            </tbody>
          </table>
        </div>   

			  @endif
          <table class="align-right">
            <th>
              <div class="badge text-wrap" style=" width: 10rem;">
                <h3 > Total: <span id="total">{{$valor}}</span> €</h3>
              </div>
            </th>
          </table>
      </div>
      <div class="modal-footer">
        <a href="{{ route ('tienda.index')}}" class="btn btn-warning btn-sm">Cerrar</a>
        <a class="btn btn-primary btn-sm" id="btnRemove">Vaciar carrito</a>
        <a class="btn btn-success btn-sm" id="btnCompra">Finalizar compra</a>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL CARRITO -->
@section('bottomJs')
<script>
    $(document).on('click',"#modal_cart_link",function(){
               $("#modal_cart").modal('show');
    });
    $(document).on('click',"#btnRemove",function(){
                
              let urlDelete = "{{route('tienda.remove')}}";
              
              
              $.ajax(urlDelete, {
                method: 'delete',
                data: {
                  _token: "{{csrf_token()}}"
                }
              }).done(function() {
                $('#message').text("Carrito vaciado correctamente").show();
                $('#modal_cart').modal('hide');
                location.reload();
              }).fail(function(xhr) {
                console.error(xhr);
              });
    });
    $(document).on('click',"#btnCompra",function(){    
              let url = "{{route('ventas.store')}}";
             
              $.ajax(url, {
                method: 'post',
                data: {
                  
                  _token: "{{csrf_token()}}"
                }
              }).done(function() {
           
                $('#message').text("Compra realizada correctamente").show();
                $('#modal_cart').modal('hide');
                location.reload();
              }).fail(function(xhr) {
                console.error(xhr);
              });
               
      });

      
      $(document).on('click',".removeItem",function(){   
        console.log('clicado menos');
        let id = $(this).data('id');
        let newQuantity = $('#quantity-' + id).data('quantity') - 1;
        let price = $('#price-' + id).data('value');
        
        cambiarCantidad(id, newQuantity, price);
        
      });
      $(document).on('click',".addItem",function(){   
        console.log('clicado mas');
        let id = $(this).data('id');
        let newQuantity = $('#quantity-' + id).data('quantity') + 1;
        let price = $('#price-' + id).data('value');
        cambiarCantidad(id, newQuantity, price);
      });

      function cambiarCantidad(id, cant, price) {
        console.log(arguments);
        let newRoute = "{{ url('tienda/carritoCambio')}}/:id/:quant";
        newRoute = newRoute.replace(":id", id).replace(':quant', cant);
        console.log("Vamos a llamar a ", newRoute);
        $.ajax(newRoute, {
          method: 'get',
          dataType: 'json',
        }).done(function(res) {
          console.log(res);
          if(res.newQuantity == 0) {
            $('#rowItem-' + id).remove();
            $('#total').text(0);
            return;
          }
          $('#price-' + id).data('value', res.newPrice);
          $('#price-' + id).text(res.newPrice);
          $('#total').text(res.total);
          $('#quantity-' + id).text(res.newQuantity).data('quantity', res.newQuantity);
        }).fail(function(err) {

        });
      } 
    

    
</script>
@endsection


