<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\AdminSupportReply;
use Illuminate\Support\Facades\Notification;

class SupportController extends Controller
{

    public function index()
    {
        // Agar murojaatlar ro'yxatini ko'rmoqchi bo'lsangiz:
        // $messages = Support::latest()->get();
        // return view('admin.support.index', compact('messages'));

        // Hozircha shunchaki sahifani qaytaramiz:
        return view('admin.support.index');
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|min:5']);
    
        $user = auth()->user();
    
        // 1. Bazaga saqlash
        \App\Models\Support::create([
            'user_id' => $user->id,
            'message' => $request->message
        ]);
    
        // 2. Telegram ma'lumotlarini olish
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
    
        // Foydalanuvchi rolini aniqlash (agar Spatie ishlatsangiz $user->getRoleNames() yoki shunchaki ustun nomi)
        $role = $user->role ?? ($user->is_admin ? 'Admin' : 'Foydalanuvchi');
    
        // Xabar matnini chiroyli formatlash
        $text = "🆘 *YANGI MUROJAAT* (ID: #{$user->id})\n\n";
        $text .= "👤 *Ism:* {$user->name}\n";
        $text .= "📧 *Email:* {$user->email}\n";
        $text .= "📞 *Tel:* " . ($user->phone ?? 'Kiritilmagan') . "\n";
        $text .= "💰 *Balans:* " . number_format($user->balance, 0, ',', ' ') . " so'm\n";
        $text .= "🛡️ *Huquqi:* {$role}\n\n";
        $text .= "💬 *Xabar:* \n_{$request->message}_";
    
        // 3. Telegram API ga yuborish (Markdown orqali chiroyli chiqadi)
        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ]);
    
        return back()->with('success', 'Murojaatingiz yuborildi. Tez orada javob beramiz!');
    }

    private function sendTelegram($text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
    
        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ]);
    
        // Agar xato bo'lsa, ekranga chiqarib to'xtatadi
        if (!$response->successful()) {
            dd($response->json()); 
        }
    }



    public function handleWebhook(Request $request)
    {
        $update = $request->all();
    
        // Telegramdan kelgan ma'lumotni tekshirish (Debug uchun)
        // \Log::info($update); 
    
        if (isset($update['message']['reply_to_message'])) {
            $replyToText = $update['message']['reply_to_message']['text'] ?? '';
            $adminAnswer = $update['message']['text'] ?? '';
    
            // ID ni qidirish: "ID: #123" formatida bo'lishi kerak
            if (preg_match('/ID: #(\d+)/', $replyToText, $matches)) {
                $userId = $matches[1];
                $user = User::find($userId);
    
                if ($user) {
                    // Xabarni yuborish
                    $user->notify(new AdminSupportReply($adminAnswer));
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Notification sent to user #' . $userId
                    ]);
                }
            }
        }
    
        return response()->json(['status' => 'ignored']);
    }
}

// https://api.telegram.org/bot<SIZNING_TOKENINGIZ>/setWebhook?url=https://sizning-saytingiz.uz/api/telegram/webhook