<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, $next)
    {
        if (auth()->check()) {
            $lastActivity = session('last_activity_time');
            $timeout = 5 * 60; // 5 daqiqa soniyalarda
    
            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                auth()->logout();
                session()->forget('last_activity_time');
                return redirect()->route('login')->with('message', 'Siz 5 daqiqa harakatsiz bo\'ldingiz va tizimdan chiqarildingiz.');
            }
    
            session(['last_activity_time' => time()]);
        }
    
        return $next($request);
    }
}
