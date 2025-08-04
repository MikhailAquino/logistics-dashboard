<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProximityWithinRange extends Notification
{
    use Queueable;

    public $log;

    public function __construct($log) { $this->log = $log; }

    public function via($notifiable) { return ['mail']; }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Proximity Alert: Delivery Within Range')
            ->line("A delivery is within {$this->log->radius} meters!")
            ->line("Distance: {$this->log->distance} m.")
            ->line('Thank you for using our app!');
    }
}