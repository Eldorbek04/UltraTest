<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BalanceTopUpNotification extends Notification
{
    use Queueable;

    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    // Bildirishnomani bazada saqlashni aytamiz
    public function via($notifiable)
    {
        return ['database'];
    }

    // Bazaga yoziladigan ma'lumotlar strukturasi
    public function toArray($notifiable)
    {
        return [
            'title' => 'Hisob to\'ldirildi',
            'message' => 'Sizning hisobingiz muvaffaqiyatli to\'ldirildi.',
            'bonus' => $this->amount, // Summani bonus sifatida ko'rsatamiz
            'icon' => 'fas fa-wallet', // Blade'dagi ikonka uchun
        ];
    }
}