<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAccountExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Foydalanuvchi tizimga kirganmi?
        // 2. Uning 'expires_at' (muddat) ustunida qiymat bormi?
        if (Auth::check() && Auth::user()->expires_at) {
            
            // Hozirgi vaqt muddatdan o'tib ketgan bo'lsa
            if (now()->greaterThan(Auth::user()->expires_at)) {
                Auth::logout(); // Tizimdan chiqarib yuborish

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Sizning kirish muddatingiz tugagan!');
            }
        }

        return $next($request);
    }
}
