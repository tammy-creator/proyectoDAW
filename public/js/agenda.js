



//document.addEventListener('DOMContentLoaded', function() {
function loadCalendar() {   
    
   
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      
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

        //initialDate: '2020-09-12',
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        
        select: function(arg) {
            
            var fecha = moment(arg.start).format("YYYY-MM-DD");  
            var hora_inicial = moment(arg.start).format("HH:mm:ss");
            var hora_final = moment(arg.end).format("HH:mm:ss");
            $("#txtFecha").val(fecha);
            $("#txtHoraInicial").val(hora_inicial);
            $("#txtHoraFinal").val(hora_final);
            $("#agenda").modal();

            calendar.unselect()
        },
        eventClick: function(arg) {
            if (confirm('Are you sure you want to delete this event?')) {
                arg.event.remove()
                $.ajax()
            }
        },

     
        editable: true,

        events: '/evento/show',

        dayMaxEvents: true, // allow "more" link when too many events
        
        
         
       

        });
    
    
    calendar.render();

    

    // function guardar(){
    //     var fd = new FormData(document.getElementById("form_evento"));
    //     let fecha =  $("#txtFecha").val();
    //     let hora_in = $("#txtHoraInicial").val();
    //     let hora_fi = $("#txtHoraFinal").val();
    //     let hora_inicial = moment(fecha+" "+hora_in).format('HH:mm:ss');
    //     let hora_final = moment(fecha+" "+hora_fi).format('HH:mm:ss');

    //     fd.append("txtHoraInicial", hora_inicial);
    //     fd.append("txtHoraFinal", hora_final);

    //     $.ajax({
    //         url: "/evento/guardar",
    //         type: "POST",
    //         data: fd,
    //         processData: false,
    //         contentType:false
    //     })
    // }
    
  };


