<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionsImport;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\User;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard()
    {
        // Tizimga kirgan foydalanuvchining sotib olgan testlari soni
        $testCount = auth()->user()->quizzes()->count();
    
        // Agar model orqali to'g'ridan-to'g'ri sanashni xohlasangiz:
        // $testCount = \App\Models\Purchase::where('user_id', auth()->id())->count();
    
        return view('admin.dashboard', compact('testCount'));
    }
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Admin hamma testlarni ko'radi
            $quizzes = Quiz::with(['category', 'user'])->latest()->paginate(5);
        } else {
            // Teacher/Tester faqat o'zi yaratganlarini ko'radi
            $quizzes = Quiz::with('category')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('admin.test.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.test.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validatsiya
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'duration' => 'required|integer',
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        // 2. Faylni yuklash
        $filePath = null;
        if ($request->hasFile('excel_file')) {
            $filePath = $request->file('excel_file')->store('tests', 'public');
        }

        // 3. Quiz yaratish (Faqat bir marta va hamma ma'lumotlar bilan)
        $quiz = Quiz::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'is_paid' => $request->is_paid ?? 0,
            'file' => $filePath,
            'price' => $request->price ?? 0,
            'duration' => $request->duration,
            'level' => $request->level ?? 'medium',
            'user_id' => auth()->id(), // Testni kim yuklayotganini shu yerda saqlaymiz
        ]);

        // 4. Excel dagi savollarni import qilish
        if ($request->hasFile('excel_file')) {
            Excel::import(new QuestionsImport($quiz->id), $request->file('excel_file'));
        }

        // Pastdagi ortiqcha $quiz = new Quiz() qismlari olib tashlandi

        return redirect()->route('admin.test.index')->with('success', 'Test muvaffaqiyatli yuklandi!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $quiz = Quiz::find($id);
        return view('admin.test.edit', compact('quiz', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'duration' => 'required|integer',
            'excel_file' => 'nullable|mimes:xlsx,xls',
        ]);

        $quiz->category_id = $request->category_id;
        $quiz->title = $request->title;
        $quiz->is_paid = $request->is_paid ?? 0;
        $quiz->price = $request->is_paid == 1 ? ($request->price ?? 0) : 0;
        $quiz->duration = $request->duration;
        // Level qatori olib tashlandi, chunki bazada bunday ustun yo'q

        if ($request->hasFile('excel_file')) {
            if ($quiz->file && \Storage::disk('public')->exists($quiz->file)) {
                \Storage::disk('public')->delete($quiz->file);
            }

            $quiz->file = $request->file('excel_file')->store('tests', 'public');
            $quiz->questions()->delete();
            \Excel::import(new QuestionsImport($quiz->id), $request->file('excel_file'));
        }

        $quiz->save(); // Endi xato bermaydi

        return redirect()->route('admin.test.index')->with('success', 'Test muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $test = Quiz::findOrFail($id);
        $test->delete();
        return redirect()->back()->with('success', 'Bitta test  O\'chirildi');
    }


    public function purchase($id)
    {
        $quiz = Quiz::findOrFail($id);
        $buyer = auth()->user();
        $author = User::find($quiz->user_id);

        // 1. Oldin sotib olganmi tekshirish
        $alreadyBought = \App\Models\Purchase::where('user_id', $buyer->id)
            ->where('quiz_id', $id)
            ->exists();
        if ($alreadyBought) {
            return redirect()->route('admin.testing.show', $id);
        }

        if ($buyer->balance < $quiz->price) {
            return back()->with('error', 'Mablag\' yetarli emas!');
        }

        try {
            DB::beginTransaction();

            $buyer->decrement('balance', $quiz->price);

            if ($author) {
                $author->increment('balance', $quiz->price * 0.10); // 10% muallifga
            }

            // 2. Xaridni bazaga yozish (Endi bu test u uchun abadiy ochiq)
            \App\Models\Purchase::create([
                'user_id' => $buyer->id,
                'quiz_id' => $id
            ]);

            DB::commit();
            return redirect()->route('admin.testing.show', $id)->with('success', 'Xarid bajarildi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Xatolik!');
        }
    }

}
