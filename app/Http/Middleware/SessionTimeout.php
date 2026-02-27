<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');
            $currentTime = time();
            $timeout = 5 * 60; // 5 daqiqa (soniyalarda)

            if ($lastActivity && ($currentTime - $lastActivity > $timeout)) {
                Auth::logout();
                session()->forget('lastActivityTime');
                return redirect()->route('login')->with('message', 'Vaqt tugadi!');
            }

            session(['lastActivityTime' => $currentTime]);
        }

        return $next($request);
    }
}