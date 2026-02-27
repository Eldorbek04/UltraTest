<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TestingController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->get('category_id');
        Quiz::paginate(10);

        $quizzes = Quiz::with('questions')
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        return view('admin.testing.index', compact('quizzes', 'categories'));
    }

    public function show(string $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);

        // Sessiyadan joriy qadamni olamiz, agar bo'lmasa 1-savoldan boshlaydi
        $step = session()->get('current_step_' . $id, 1);

        // Agar hamma savollar tugagan bo'lsa, submitga yuboramiz
        if ($step > $quiz->questions->count()) {
            return $this->submit(request()->merge(['quiz_id' => $id]));
        }

        $sessionKey = 'quiz_end_time_' . $id;
        if (!session()->has($sessionKey)) {
            $endTime = time() + ($quiz->duration * 60);
            session()->put($sessionKey, $endTime);
        }

        $timeLeft = session()->get($sessionKey) - time();

        // View-ga $step o'zgaruvchisini ham uzatamiz
        return view('admin.testing.show', compact('quiz', 'timeLeft', 'step'));
    }

    public function saveAnswer(Request $request)
    {
        $quiz_id = $request->quiz_id;
        $sessionKey = 'quiz_answers_' . $quiz_id;
        $answers = session()->get($sessionKey, []);

        if ($request->has('question_id')) {
            $answers[$request->question_id] = $request->answer;
        }

        session()->put($sessionKey, $answers);

        // KEYINGI QADAMNI SESSIYADA SAQLAYMIZ (URLda emas)
        $nextStep = (int) $request->step + 1;
        session()->put('current_step_' . $quiz_id, $nextStep);

        if ($request->has('time_left')) {
            session()->put('quiz_time_left_' . $quiz_id, $request->time_left);
        }

        // URLda endi 'step' bo'lmaydi
        return redirect()->route('admin.testing.show', $quiz_id);
    }

    public function submit(Request $request)
    {
        $quiz_id = $request->quiz_id;
        $sessionKey = 'quiz_answers_' . $quiz_id;
        $userAnswers = session()->get($sessionKey, []);

        if ($request->has('answer') && $request->has('question_id')) {
            $userAnswers[$request->question_id] = $request->answer;
        }

        $quiz = Quiz::with('questions')->findOrFail($quiz_id);
        $allQuestions = $quiz->questions;

        $correct = 0;
        foreach ($allQuestions as $q) {
            $userChoice = $userAnswers[$q->id] ?? null;
            if ($userChoice) {
                $cleanUser = strtolower(trim($userChoice));
                $cleanReal = strtolower(trim($q->correct_answer));
                if ($cleanUser === $cleanReal) {
                    $correct++;
                }
                $q->user_choice = $cleanUser;
            } else {
                $q->user_choice = null;
            }
        }

        $total = $allQuestions->count();
        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        // --- MANA SHU QISIM BAZAGA SAQLAYDI ---
        \App\Models\Result::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz_id,
            'score' => $percentage, // Foizni saqlaymiz
            'correct_answers' => $correct, // Agar jadvalda bo'lsa
            'total_questions' => $total,   // Agar jadvalda bo'lsa
        ]);
        // --------------------------------------

        session()->forget([$sessionKey, 'quiz_end_time_' . $quiz_id]);

        return view('admin.testing.result', [
            'quiz' => $quiz,
            'correct' => $correct,
            'total' => $total,
            'percentage' => $percentage,
            'answeredCount' => count($userAnswers),
            'questions' => $allQuestions
        ]);

        // submit metodi ichida:
        session()->forget([
            $sessionKey,
            'quiz_end_time_' . $quiz_id,
            'current_step_' . $quiz_id // Buni qo'shing
        ]);
    }


    public function purchase(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $user = auth()->user();

        if ($user->balance < $quiz->price) {
            // Balansni formatlab xabar yuboramiz
            $currentBalance = number_format($user->balance, 0, ',', ' ');
            return back()->with('error', "Hisobingizda mablag' yetarli emas. Sizning balansingiz: {$currentBalance} so'm");
        }

        $user->decrement('balance', $quiz->price);
        return redirect()->route('admin.testing.show', $id)->with('success', "Test muvaffaqiyatli sotib olindi.");
    }

    public function terminate($id)
{
    // Ushbu testga tegishli barcha sessiya ma'lumotlarini tozalaymiz
    session()->forget([
        'quiz_answers_' . $id,
        'quiz_end_time_' . $id,
        'current_step_' . $id,
        'quiz_time_left_' . $id
    ]);

    return redirect()->route('admin.testing.index')->with('info', 'Test jarayoni bekor qilindi.');
}
}