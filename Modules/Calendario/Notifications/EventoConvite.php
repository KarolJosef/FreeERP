<?php

namespace Modules\Calendario\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Calendario\Entities\Evento;

class EventoConvite extends Notification
{
    use Queueable;
    private $evento;

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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Olá!')
                    ->subject('Convite para evento')
                    ->line('Você foi convidado para um evento.')
                    ->line('Evento: ' .  $this->evento->titulo)
                    ->line('Criado por:' . $this->evento->agenda->funcionario->nome)
                    ->action('Confirme sua presença', 'https://127.0.0.1:8000/calendario');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}