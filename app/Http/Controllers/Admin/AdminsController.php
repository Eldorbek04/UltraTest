<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Statistika
        $totalTests = Quiz::count();
        $totalUsers = User::count();
    

        $admins = User::role(['admin', 'teacher', 'tester'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(5); // <--- Mana shu yer!
    
        $roles = \Spatie\Permission\Models\Role::all();
    
        return view('admin.admin.index', compact('admins', 'roles', 'totalTests', 'totalUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Barcha rollarni bazadan olish
        return view('admin.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required',
            'duration' => 'required'
        ]);
    
        // Muddatni hisoblash (Duration mantiqi)
        $expiresAt = null; // Default: Cheksiz
    
        if ($request->duration == '1') {
            $expiresAt = now()->addDays(1);
        } elseif ($request->duration == '30') {
            $expiresAt = now()->addDays(30);
        } elseif ($request->duration == '60') {
            $expiresAt = now()->addDays(60);
        } elseif ($request->duration == '90') {
            $expiresAt = now()->addDays(90);
        } elseif ($request->duration == '365') {
            $expiresAt = now()->addYear(); // 1 yil qo'shish
        } 
    
        // 1. Foydalanuvchini yaratish
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'expires_at' => $expiresAt, // SHU YERDA SAQLANYAPTIMI?
        ]);
    
        // 2. Rol biriktirish
        $user->assignRole($request->role);
    
        return redirect()->back()->with('success', 'Yangi admin va uning ruxsat muddati muvaffaqiyatli saqlandi!');
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
        $admin = User::findOrFail($id);
        $roles = Role::all(); // Rollarni tanlash imkoniyati uchun
        return view('admin.admin.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:8', // Parol ixtiyoriy (agar o'zgartirmoqchi bo'lsa)
            'role'     => 'required',
            'duration' => 'required'
        ]);

        // Muddatni qayta hisoblash
        $expiresAt = $admin->expires_at; // Eskisini saqlab turamiz

        if ($request->duration !== 'current') { // Agar yangi muddat tanlansa
            if ($request->duration == 'unlimited') {
                $expiresAt = null;
            } else {
                $expiresAt = now()->addDays((int)$request->duration);
            }
        }

        // Ma'lumotlarni yangilash
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->expires_at = $expiresAt;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        // Rolni yangilash (Eski rollarni o'chirib, yangisini yuklaydi)
        $admin->syncRoles([$request->role]);

        return redirect()->route('admin.admin.index')->with('success', 'Admin ma\'lumotlari yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->back()->with('success', 'Bitta Kategorya
          O\'chirildi');
    }

}
