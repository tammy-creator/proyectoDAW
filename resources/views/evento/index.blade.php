@extends('layouts.main', ['activePage' => 'evento', 'titlePage' => 'Calendario'])
@section('content')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">

                  <div id="message" class="alert alert-success" style="display:none"></div>

                  <div id="alert" class="alert alert-warning" style="display:none"></div>

                  <div id="confirm" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Eliminar Evento de Agenda</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>¿Estas seguro de eliminar el evento?</p>
                        </div>
                        <div class="modal-footer">
                          <button id="btnConfirm" type="button" class="btn btn-primary">Eliminar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-header card-header-primary">
                    <h3 class="card-title">Calendario</h3>
                  </div>

                  <div class="card-body">
                    <div id='calendar'></div>

                    {{-- <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modelId">
                      Launch
                    </button> --}}
                    
                    <!-- Modal -->
                    <div class="modal fade" id="agenda" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Evento</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                            <form id="form_evento">
                              @csrf
                              <div class="row">

                                <div class="col-6">
                                  <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" id="txtFecha" name="fecha">
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="form-group">
                                    <label for="horaInicial">Hora Inicial</label>
                                    <input type="time" class="form-control" id="txtHoraInicial" name="hora_inicio">
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="form-group">
                                    <label for="horaFinal">Hora Final</label>
                                    <input type="time" class="form-control" id="txtHoraFinal" name="hora_final">
                                  </div>
                                </div>

                              </div>
                              
                              @if(auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)
                              <div class="form-group">
                                <label for="terapeuta">Terapeuta</label>
                                <select name="terapeuta_id" id="id_terapeuta" class="form-control">
                                  <option value="">Seleccione Terapeuta</option>                                    
                                  
                                  @foreach ($users as $user)
                                    @foreach ($user->roles as $role)                                         
                                      @if ($role->id == PR_ROL_TERAPEUTA_ID)                                        
                                        <option value="{{$user->id}}">{{$user->name}}</option>                                        
                                      @endif                                       
                                    @endforeach
                                  @endforeach

                                </select>                                  
                              </div>
                              @endif
                             
                              @if(auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID || auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <select name="user_id" id="id_usuario" class="form-control">
                                      <option value="">Seleccione Usuario</option>
                                     
                                        @foreach ($users as $user)
                                          @foreach ($user->roles as $role) 
                                         
                                            @if ($role->id == PR_ROL_USUARIO_ID)
                                              @if(auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                              @else 
                                                @if(auth()->user()->id == $user->terapeuta_id)
                                                  <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endif
                                              @endif 
                                            @endif                                      
                                          @endforeach
                                        @endforeach
                                      
                                    </select>                                  
                                  </div>                                  
                                </div> 
                              </div>
                              @endif 
                              @if(auth()->user()->roles()->first()->id == PR_ROL_USUARIO_ID)
                              <input type="hidden" name="terapeuta_id" value="{{auth()->user()->terapeuta_id}}">
                              <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                              @endif
                              @if(auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)
                              <input type="hidden" name="terapeuta_id" value="{{auth()->user()->id}}">                              
                              @endif

                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="btnGuardar" class="btn btn-primary" disabled>Guardar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="card-footer mr-auto">
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>
@section('bottomJs')
<script>
  let calendar;
  $("#btnGuardar").on("click", function(){
        
        let datos = $('#form_evento').serialize();

        axios.post("{{route('evento.store')}}", datos).then(
            (respuesta) => {      
               
              $("#agenda").modal("hide"); 
              //console.log(calendar);
               calendar.refetchEvents();     
              $('#message').text("Evento registrado correctamente").show();              
                     
            }
            ).catch(
                error=>{
                    if(error.response){
                        console.error(error.response.data);
                    }
                }
              )
  });
 $(function() {
 
    let aceptarGuardar = false;
    @if(auth()->user()->roles()->first()->id == PR_ROL_USUARIO_ID || auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID)
      $('#btnGuardar').prop('disabled', false);
    
    @else
    $('select[name=user_id]').on('change', function(e) {
      if($.isNumeric($(this).val()) && $.isNumeric($('select[name=terapeuta_id] option').filter(':selected').val())) {
        aceptarGuardar = true;
        $('#btnGuardar').prop('disabled', false);
      }
      else
        $('#btnGuardar').prop('disabled', true);

    });
    
    $('select[name=terapeuta_id]').on('change', function(e) {
      if($.isNumeric($(this).val()) && $.isNumeric($('select[name=user_id] option').filter(':selected').val())) {
        aceptarGuardar = true;
        $('#btnGuardar').prop('disabled', false);
      }else
        $('#btnGuardar').prop('disabled', true);

    });
   @endif
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
      
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        locale:"es",       

        initialView: 'timeGridWeek',       
        
        businessHours: {
            // days of week. an array of zero-based day of week integers (0=Sunday)
            daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Friday
          
            startTime: '10:00', // a start time (10am in this example)
            endTime: '19:00', // an end time (7pm in this example)
        },
        
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        
        select: function(arg) {
            
            let inicio = moment(arg.start);
            let hoy = new moment().format("YYYY-MM-DD");
            let fecha = moment(arg.start).format("YYYY-MM-DD");  
            let hora_inicial = moment(arg.start).format("HH:mm:ss");
            let hora_final = moment(arg.end).format("HH:mm:ss");
            //Anular los clics fuera de horario laboral
            if(inicio.day()<1||inicio.day()>5 || inicio.hour()<10 || inicio.hour()>19) {
              $('#alert').text("No es posible agendar").show();
              
              return false;
            }
            
            @if($roleUserLogged->id == PR_ROL_USUARIO_ID)
              //Si clico en un evento del mismo día, no hago nada
              if(moment(fecha).isSameOrBefore(hoy)) {
                $('#alert').text("No es posible agendar").show();
                
                return;
              }
              
            @endif
            $('#alert').hide();
            $("#txtFecha").val(fecha);
            $("#txtHoraInicial").val(hora_inicial);
            $("#txtHoraFinal").val(hora_final);
            $("#agenda").modal();

            calendar.unselect()
        },
         

        eventClick: function(arg) {
            console.log("Evento clicado", arg);
            @if($roleUserLogged->id == PR_ROL_USUARIO_ID)
              //Si clico en un evento que es de colo rojo, no hago nada
              if(arg.event._def.extendedProps.user_id != {{ auth()->user()->id }})
                return;
              let fechaClick = moment(arg.el.fcSeg.start).format("YYYY-MM-DD");
              let today = new Date();
              if(moment(fechaClick).isSameOrBefore(today)) { 
                              
                $('#alert').text("No es posible cancelar cita").show();
                
                return;
              }
            
            @endif
            $("#confirm").modal('show');

            document.getElementById("btnConfirm").onclick = function() {
                arg.event.remove();
              //console.log(arg);
              let urlDelete = "{{route('evento.delete', ':id')}}";
              
              let idEvent = arg.event._def.publicId;
              
              urlDelete = urlDelete.replace(":id", idEvent);
              
              $.ajax(urlDelete, {
                method: 'delete',
                data: {
                  _token: "{{csrf_token()}}"
                }
              }).done(function(res) {
                $('#message').text("Evento eliminado correctamente").show();
                $('#confirm').modal('hide');
              }).fail(function(xhr) {
                console.error(xhr);
              });
            }
        },
       
        editable: true,

        events: '{{route('evento.show')}}',

        dayMaxEvents: true, // allow "more" link when too many events       
        
        });    
    
    calendar.render();
    // console.log(calendar);  
  
 });
 
  </script>
@endsection