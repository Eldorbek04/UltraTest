<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting; // Setting modelini qo'shishni unutmang
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie; // Cookie uchun
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\ReferralBonusReceived;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        // 1. Validatsiya
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);
    
        // 2. Cookie-dan taklif qilgan odamning kodini olish (Middleware saqlagan bo'lishi kerak)
        $referredByCode = Cookie::get('referrer');
        $referrer = User::where('referral_code', $referredByCode)->first();
    
        // 3. Foydalanuvchini yaratish
        $welcomeBonus = get_setting('welcome_bonus', 0); // Sozlamalardan bonusni olish
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'balance' => $welcomeBonus,
            'referral_code' => strtoupper(Str::random(8)),
            'referrer_id' => $referrer ? $referrer->id : null, // TAKLIF QILUVCHINI BOG'LASH
        ]);
    
        // 4. Yangi foydalanuvchiga "Xush kelibsiz" bildirishnomasi
        if ($welcomeBonus > 0) {
            $user->notify(new ReferralBonusReceived("Tizim", $welcomeBonus));
        }
    
        // 5. Taklif qilgan odamga (referrer) bonus berish va bildirishnoma yuborish
        if ($referrer) {
            $referralBonus = get_setting('referral_bonus', 0);
            
            // Balansini oshirish
            $referrer->increment('balance', $referralBonus);
            
            // Bildirishnoma yuborish
            $referrer->notify(new ReferralBonusReceived($user->name, $referralBonus));
        }
    
        // 6. Ro'yxatdan o'tganini qayd etish va login
        event(new Registered($user));
        Auth::login($user);
    
        return redirect()->route('admin.dashboard'); // Yoki sizning asosiy sahifangiz
    }
}