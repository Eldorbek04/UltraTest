<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqModel;
use App\Models\Purchase;
use App\Models\Quiz;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Jami yechilgan testlar
        $totalFinishedTests = \App\Models\Result::where('user_id', $user->id)->count();

        // Pullik yechilgan testlar (Agar Result modelida 'type' yoki 'is_paid' ustuni bo'lsa)
// Yoki Results jadvalini Quizzes jadvali bilan bog'lab hisoblaymiz:
        $paidTestsCount = \App\Models\Result::where('user_id', $user->id)
            ->whereHas('quiz', function ($query) {
                $query->where('price', '>', 0);
            })->count();

        $freeTestsCount = $totalFinishedTests - $paidTestsCount;
        
        // 1. Sotib olingan testlarni sanash
        $testCount = Purchase::where('user_id', auth()->id())->count();

        // 2. FAQ ma'lumotlarini olish (Slayder xato bermasligi uchun)
        $faq = FaqModel::all();

        // 3. Viewga uzatish (compact ichida o'zgaruvchi nomini yozing)
        return view('admin.dashboard', compact('testCount', 'faq'));
    }
}
