<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hisob; // O'z modelingiz nomini tekshiring
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HisobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.hisob.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'many' => 'required|numeric|min:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        try {
            $data = new Hisob();
            $data->user_id = Auth::id();
            $data->many = $request->many;
            $data->status = 'pending';
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/cheks/'), $filename);
                $data->image = 'uploads/cheks/' . $filename;
            }
    
            $data->save();

            // Botga oddiy xabar yuborish funksiyasini chaqiramiz
            $this->notifyBot($data);
    
            return redirect()->back()->with('success', 'Chek qabul qilindi. Admin tez orada ko\'rib chiqadi!');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }

    // Botga xabar yuborish metodi
    private function notifyBot($payment)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chat_id = env('TELEGRAM_ADMIN_CHAT_ID');
        $user = Auth::user();

        $text = "💰 *Yangi to'lov so'rovi!*\n\n";
        $text .= "👤 *Foydalanuvchi:* " . $user->name . "\n";
        $text .= "💵 *Summa:* " . number_format($payment->many) . " so'm\n";
        $text .= "🆔 *To'lov ID:* #" . $payment->id . "\n";
        $text .= "⏳ *Holati:* Kutilmoqda";

        // Telegramga rasm va matnni yuborish
        // Lokal-da asset() funksiyasi ishlashi uchun internet kerak, 
        // lekin xabar baribir boradi (rasm chiqmasa ham)
        Http::post("https://api.telegram.org/bot{$token}/sendPhoto", [
            'chat_id' => $chat_id,
            'photo' => asset($payment->image), 
            'caption' => $text,
            'parse_mode' => 'Markdown'
        ]);
    }

    private function sendToTelegram($payment)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $admin_id = env('TELEGRAM_ADMIN_CHAT_ID');

        $text = "💰 *Yangi to'lov so'rovi!* \n\n";
        $text .= "👤 Foydalanuvchi: " . auth()->user()->name . "\n";
        $text .= "💵 Summa: " . number_format($payment->many) . " so'm\n";
        $text .= "🆔 To'lov ID: #{$payment->id}";

        // Inline tugmalar
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => "✅ Tasdiqlash", 'callback_data' => "pay_approve_{$payment->id}"],
                    ['text' => "❌ Rad etish", 'callback_data' => "pay_reject_{$payment->id}"]
                ]
            ]
        ];

        // Rasmni yuborish (Lokalda bo'lsangiz rasm bormasligi mumkin, shuning uchun 'photo' o'rniga text yuborish variantini ham ko'ring)
        Http::post("https://api.telegram.org/bot{$token}/sendPhoto", [
            'chat_id' => $admin_id,
            'photo' => ($this->isLocal()) ? "https://via.placeholder.com/300" : asset($payment->image),
            'caption' => $text,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode($keyboard)
        ]);
    }

    private function isLocal()
    {
        return str_contains(request()->getHttpHost(), '127.0.0.1') || str_contains(request()->getHttpHost(), 'localhost');
    }
}