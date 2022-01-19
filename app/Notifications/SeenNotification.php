<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class SeenNotification extends Notification
{
    use Queueable;
protected $seennoti;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($seennoti)
    {
        $this->seennoti=$seennoti;
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


    public function toDatabase($notifiable)
    {
        
       
      return [
                'ways'=>$this->seennoti,
            ];  
    }
}
