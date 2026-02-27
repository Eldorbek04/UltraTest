<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // withCount('purchases') orqali har bir userga 'purchases_count' ustunini qo'shib olamiz
        $query = User::withCount('purchases');
    
        // Qidiruv mantiqi
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    
        // Sotib olingan testlar soni bo'yicha kamayish tartibida saralash
        // Shunda eng ko'p test olgan foydalanuvchi birinchi chiqadi
        $users = $query->orderBy('purchases_count', 'desc')->paginate(5);
        
        $totalUsers = User::count();
        // Jami ishlangan testlar (Natijalar jadvalidan)
        $totalTestsTaken = \App\Models\Result::count(); 
    
        return view('admin.users.index', compact('users', 'totalUsers', 'totalTestsTaken'));
    }

    public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    $user->is_active = !$user->is_active; // true bo'lsa false qiladi va aksincha
    $user->save();

    return redirect()->back()->with('success', 'Foydalanuvchi holati o\'zgardi!');
}

protected function authenticated(Request $request, $user)
{
    if (!$user->is_active) {
        auth()->logout();
        return redirect()->route('login')->withErrors(['email' => 'Sizning hisobingiz bloklangan!']);
    }
}

public function create()
{
    return view('admin.users.create');
}
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $users = User::all();
    $title = $request->title;
    $message = $request->message;

    // Barcha userlarga bildirishnoma yuborish
    Notification::send($users, new GeneralNotification($title, $message));

    return redirect()->route('admin.users.index')->with('success', "Bildirishnoma muvaffaqiyatli yuborildi!");
}

public function show(string $id)
{
    // Foydalanuvchini topamiz yoki 404 xatolik qaytaramiz
    // withCount orqali bog'langan ma'lumotlar sonini tezroq olamiz
    $user = User::withCount(['purchases', 'results'])
                ->withAvg('results', 'score')
                ->findOrFail($id);

    // Foydalanuvchining oxirgi topshirgan testlari (Natijalari)
    $recentResults = \App\Models\Result::where('user_id', $id)
                        ->with('quiz') // Test nomini ko'rish uchun
                        ->latest()
                        ->take(10)
                        ->get();

    // Foydalanuvchi sotib olgan testlar ro'yxati
    $purchasedQuizzes = $user->quizzes()->latest()->get();

    return view('admin.users.show', compact('user', 'recentResults', 'purchasedQuizzes'));
}
}