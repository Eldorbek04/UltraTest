<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hisob;
use App\Models\User;
use App\Notifications\PaymentStatusNotification; // Avvalgi darsdagi notification
use Illuminate\Support\Facades\Http;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $update = $request->all();

        if (isset($update['callback_query'])) {
            $data = $update['callback_query']['data']; // masalan: pay_approve_5
            $callbackId = $update['callback_query']['id'];
            $chatId = $update['callback_query']['message']['chat']['id'];
            $messageId = $update['callback_query']['message']['message_id'];

            $parts = explode('_', $data);
            $action = $parts[1]; // approve yoki reject
            $paymentId = $parts[2];

            $payment = \App\Models\Hisob::find($paymentId);

            if (!$payment || $payment->status !== 'pending') {
                return $this->answer($callbackId, "Xatolik: To'lov topilmadi yoki allaqachon bajarilgan.");
            }

            $user = \App\Models\User::find($payment->user_id);

            if ($action === 'approve') {
                // 1. Foydalanuvchi balansini oshirish
                $user->increment('balance', $payment->many);
                $payment->update(['status' => 'success']);
                $resultText = "✅ Tasdiqlandi: Foydalanuvchi balansiga " . number_format($payment->many) . " so'm qo'shildi.";

                // 2. Foydalanuvchiga saytda xabar (Notification)
                $user->notify(new \App\Notifications\PaymentStatusNotification([
                    'title' => 'To\'lov qabul qilindi',
                    'message' => "Sizning " . number_format($payment->many) . " so'mlik to'lovingiz tasdiqlandi.",
                    'icon' => 'fas fa-check-circle'
                ]));
            } else {
                // Rad etish
                $payment->update(['status' => 'rejected']);
                $resultText = "❌ Rad etildi: To'lov bekor qilindi.";

                $user->notify(new \App\Notifications\PaymentStatusNotification([
                    'title' => 'To\'lov rad etildi',
                    'message' => "Chekda xatolik borligi sababli to'lov rad etildi.",
                    'icon' => 'fas fa-times-circle'
                ]));
            }

            // Telegramdagi xabarni yangilash (tugmalarni o'chirish va natijani yozish)
            $this->editTelegramMessage($chatId, $messageId, $resultText);
        }

        return response('OK', 200);
    }

    private function updateTelegramMessage($chatId, $messageId, $newText)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$token}/editMessageCaption", [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'caption' => $newText,
            'reply_markup' => json_encode(['inline_keyboard' => []]) // Tugmalarni o'chirish
        ]);
    }

    private function answerCallback($callbackId, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$token}/answerCallbackQuery", [
            'callback_query_id' => $callbackId,
            'text' => $text
        ]);
    }
}