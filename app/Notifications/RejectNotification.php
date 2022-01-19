<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectNotification extends Notification
{
    use Queueable;
protected $waynoti;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($waynoti)
    {
        $this->waynoti=$waynoti;
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
            'ways'=>$this->waynoti,
        ];
    }
}
