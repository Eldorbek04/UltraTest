<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Foydalanuvchini topamiz
        $user = \App\Models\User::where('email', $request->email)->first();
    
        // if ($user && $user->last_session_id) {
        //     // Agar bazada sessiya ID bo'lsa, demak kimdir ichkarida
        //     return redirect()->route('login')->withErrors([
        //         'email' => 'Ushbu akkauntda hozirda boshqa qurilmada kirgan.',
        //     ]);
        // }

        // 1 akkauntga 2 kishi kiromidgan qilish
    
        // 2. Login qilish
        $request->authenticate();
        $request->session()->regenerate();
    
        // 3. Yangi sessiya ID-sini bazaga saqlash
        $authUser = Auth::user();
        $authUser->last_session_id = session()->getId();
        $authUser->save();
    
        return redirect()->intended(\App\Providers\RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
/**
 * Destroy an authenticated session.
 */
public function destroy(Request $request): RedirectResponse
{
    $user = Auth::user();

    if ($user) {
        // Tizimdan chiqayotganda bazadagi sessiya ID sini tozalaymiz
        // Shunda foydalanuvchi qayta kirganda "akkaunt band" degan xato chiqmaydi
        $user->last_session_id = null;
        $user->save();
    }

    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}
}
