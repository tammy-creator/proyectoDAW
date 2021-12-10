<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\carbon;
use App\Models\Evento;
use App\Models\User;

class EventoNotification extends Notification
{
    public $evento;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'evento' => $this->evento->id,
            'user_id' => $this->evento->user_id,
            'user_name' => User::find($this->evento->user_id)->name,
            'terapeuta_id' => $this->evento->terapeuta_id,  
            'terapeuta_name' => User::find($this->evento->terapeuta_id)->name,      
            'fecha'=> $this->evento->fecha,
            'hora_inicio'=> $this->evento->hora_inicio,
            'hora_final'=> $this->evento->hora_final, 
            'time' => Carbon::now()->diffForHumans(),

        ];
    }
}
