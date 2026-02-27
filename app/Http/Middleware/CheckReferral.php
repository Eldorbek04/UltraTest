<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class CheckReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Linkda 'ref' borligini tekshirish (masalan: ?ref=ABC12345)
        if ($request->has('ref')) {
            // 2. Ushbu kodni brauzer kuki (cookie) xotirasiga 1 oyga saqlab qo'yish
            Cookie::queue('referrer', $request->query('ref'), 43200);
        }

        return $next($request);
    }
}
