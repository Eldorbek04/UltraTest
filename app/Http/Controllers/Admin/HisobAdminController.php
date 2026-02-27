<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hisob; // Modelni import qilish shart
use App\Models\User;
use App\Notifications\PaymentStatusNotification;

class HisobAdminController extends Controller
{
    /**
     * Faqat 'pending' (kutilayotgan) to'lovlarni ko'rsatamiz
     */
    public function index()
    {
        // Kutilayotgan to'lovlarni foydalanuvchi ma'lumotlari bilan olish
        $payments = Hisob::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.hisobadmin.index', compact('payments'));
    }

    /**
     * To'lovni tasdiqlash
     */
    public function approve($id) {
        $payment = Hisob::findOrFail($id);
        $user = $payment->user;
    
        $user->balance += $payment->many; 
        $user->save();
    
        $payment->status = 'success';
        $payment->save();
    
        // Bildirishnoma yuborish
        $user->notify(new PaymentStatusNotification([
            'title' => 'To\'lov tasdiqlandi!',
            'message' => "Sizning " . number_format($payment->many) . " so'mlik to'lovingiz qabul qilindi. Balansingiz to'ldirildi.",
            'icon' => 'fas fa-check-circle',
            'status' => 'success'
        ]));
    
        return redirect()->back()->with('success', "Tasdiqlandi va foydalanuvchiga xabar yuborildi.");
    }
    
    // Rad etish metodi
    public function reject($id) {
        $payment = Hisob::findOrFail($id);
        $user = $payment->user;
    
        $payment->status = 'rejected';
        $payment->save();
    
        // Bildirishnoma yuborish
        $user->notify(new PaymentStatusNotification([
            'title' => 'To\'lov rad etildi',
            'message' => "Siz yuborgan " . number_format($payment->many) . " so'mlik to'lov cheki admin tomonidan rad etildi. Iltimos, qaytadan tekshirib yuboring.",
            'icon' => 'fas fa-times-circle',
            'status' => 'danger'
        ]));
    
        return redirect()->back()->with('error', "Rad etildi va foydalanuvchiga xabar yuborildi.");
    }

    /**
     * To'lovni rad etish
     */
}