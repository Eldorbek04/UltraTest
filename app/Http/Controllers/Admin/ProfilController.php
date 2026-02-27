<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class ProfilController extends Controller
{
    public function index()
    {
        // Bazadagi hamma foydalanuvchilarni olish
        $profils = User::all();
        // Olingan ma'lumotlarni view-ga (sahifaga) yuborish
        return view('admin.profile.index', compact('profils'));
    }


    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
    
        // 1. Validatsiya qoidalari
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Agar parol maydoni to'ldirilgan bo'lsa, quyidagilarni tekshir:
            'old_password' => 'nullable|required_with:password',
            'password' => [
                'nullable', 
                'confirmed', 
                Password::min(8)->letters()->numbers() // Kamida 8 ta belgi, harf va raqam
            ],
        ]);
    
        // 2. Parolni tekshirish va o'zgartirish
        if ($request->filled('password')) {
            // Eski parolni bazadagi bilan solishtirish
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Eski parol noto‘g‘ri!'])->withInput();
            }
    
            // Yangi parolni shifrlash
            $user->password = Hash::make($request->password);
        }
    
        // 3. Boshqa ma'lumotlar
        $user->name = $request->name;
        $user->phone = $request->phone;
    
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('profiles', 'public');
        }
    
        $user->save();
    
        return back()->with('success', 'Profil va parol muvaffaqiyatli yangilandi!');
    }
}
