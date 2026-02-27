<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentStatusNotification extends Notification
{
    use Queueable;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database']; // Xabarni bazaga saqlaymiz
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->details['title'],
            'message' => $this->details['message'],
            'icon' => $this->details['icon'],
            'status' => $this->details['status']
        ];
    }
}