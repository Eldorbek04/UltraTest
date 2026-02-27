<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReferralBonusReceived extends Notification
{
    use Queueable;

    protected $newUserName;
    protected $bonusAmount;

    public function __construct($newUserName, $bonusAmount)
    {
        $this->newUserName = $newUserName;
        $this->bonusAmount = $bonusAmount;
    }

    // Bildirishnoma qayerda saqlansin? (Database - bazada saqlash)
    public function via($notifiable)
    {
        return ['database'];
    }

    // Bazaga yoziladigan ma'lumotlar
    public function toArray($notifiable)
    {
        // Agar jo'natuvchi nomi "Tizim" bo'lsa, demak bu yangi foydalanuvchining o'zi
        if ($this->newUserName === "Tizim") {
            $message = "Xush kelibsiz! Ro'yxatdan o'tganingiz uchun sizga bonus berildi.";
            $icon = "fas fa-gift";
        } else {
            $message = "Tabriklaymiz! {$this->newUserName} sizning havolangiz orqali ro'yxatdan o'tdi.";
            $icon = "fas fa-user-plus";
        }
    
        return [
            'message' => $message,
            'bonus' => $this->bonusAmount,
            'icon' => $icon,
        ];
    }
}