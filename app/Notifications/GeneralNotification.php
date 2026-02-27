<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        // Faqat bazaga saqlash (database kanali)
        return ['database'];
    }

    public function toArray($notifiable)
    {
        // Jadvaldagi 'data' ustuniga JSON bo'lib tushadigan ma'lumot
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }
}