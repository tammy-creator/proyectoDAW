<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use \DB;
use App\Notifications\EventoNotification;
use Illuminate\Support\Facades\Notification;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $roles=Role::all();
        $roleUserLogged = auth()->user()->roles()->first();
        return view('evento.index', compact('users','roles', 'roleUserLogged'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         request()->validate(Evento::$rules);     
        
         $evento=Evento::create($request->all());

        if(auth()->user()->roles()->first()->id == PR_ROL_TERAPEUTA_ID || auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID ){
            User::all()
                ->only($evento->user_id)
                ->each(function(User $user) use ($evento){
                    $user->notify(new EventoNotification($evento));
                });
        }
        if(auth()->user()->roles()->first()->id == PR_ROL_USUARIO_ID || auth()->user()->roles()->first()->id == PR_ROL_ADMINISTRADOR_ID ){
            User::all()
                ->only($evento->terapeuta_id)
                ->each(function(User $user) use ($evento){
                    $user->notify(new EventoNotification($evento));
                });    
        }
         return response()->json([
            'status' => 1,
            'message' => 'Evento creado correctamente',
        ]);
                 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento, Request $request)
    {
        //validation
        $request->validate([
           'start'=> 'required|date',
           'end'=> 'required|date'
        ]);

        
        $fechaHoraIni = (new Carbon($request->start))->toDateTimeString();
        
        $fechaHoraFin = (new Carbon($request->end))->toDateTimeString();

        $roleUser = User::find(auth()->user()->id)->roles()->first();
        
      
        $eventos = Evento::select('eventos.*', 'users.name', DB::raw("date(concat(eventos.fecha, ' ' ,eventos.hora_inicio)) AS fechaHoraInicio"))->join('users', 'users.id', '=', 'eventos.user_id');
        $eventos = $eventos->havingBetween('fechaHoraInicio', [$fechaHoraIni, $fechaHoraFin]);
        if($roleUser->id == PR_ROL_TERAPEUTA_ID) {
            $eventos = $eventos->where('eventos.terapeuta_id',auth()->user()->id);
        }
        if($roleUser->id == PR_ROL_USUARIO_ID) {
            $eventos = $eventos->orWhere('eventos.user_id',auth()->user()->id);
        }

        $eventos = $eventos->get();
        
        $nuevosEventos = [];
        foreach($eventos as $value){
            $nuevosEventos[] = [
                "id"=> $value->id,
                "start"=>$value->fecha." ".$value->hora_inicio,
                "end"=>$value->fecha." ".$value->hora_final,
                "title"=>$value->name,
                "backgroundColor"=>"#3788d8",
                "textColor"=>"#fff",
                "extendedProps"=>[
                    "user_id"=>$value->user_id,
                    "terapeuta_id"=>$value->terapeuta_id
                ]
            ];
        }
        
        $bookings = self::showTherapistBookings($evento, $request);

        
        foreach($bookings as $booking) {
           
            $nuevosEventos[]= $booking;
        }
        
        return response()->json($nuevosEventos);
    }

    public function showTherapistBookings(Evento $evento, Request $request) {
       //validation
       $request->validate([
        'start'=> 'required|date',
        'end'=> 'required|date'
        ]);

        
        $fechaHoraIni = (new Carbon($request->start))->toDateTimeString();
        
        $fechaHoraFin = (new Carbon($request->end))->toDateTimeString();

        $eventos = Evento::select('eventos.*', 'users.name', DB::raw("date(concat(eventos.fecha, ' ' ,eventos.hora_inicio)) AS fechaHoraInicio"))
        ->join('users', 'users.id', '=', 'eventos.terapeuta_id')
        ->whereRaw('eventos.terapeuta_id = (select terapeuta_id from users where id=?)', [auth()->user()->id])
        ->where('eventos.user_id', '<>', auth()->user()->id)
        ->havingBetween('fechaHoraInicio', [$fechaHoraIni, $fechaHoraFin])->get();
        
        $nuevoEvento = [];
        foreach($eventos as $value){
            
            $nuevoEvento[] = [
                "id"=> $value->id,
                "start"=>$value->fecha." ".$value->hora_inicio,
                "end"=>$value->fecha." ".$value->hora_final,
                "title"=>"OCUPADO",
                "backgroundColor"=>"red",
                "textColor"=>"#fff",
                "extendedProps"=>[
                    "user_id"=>$value->user_id,
                    "terapeuta_id"=>$value->terapeuta_id
                ]
            ];
        }
        return $nuevoEvento;  
        return response()->json($nuevoEvento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::find($id)->delete();
       
        return response()->json($evento);
    }
}
