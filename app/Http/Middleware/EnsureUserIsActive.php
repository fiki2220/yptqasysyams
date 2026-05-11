<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login?
        if (Auth::check()) {
            
            // 2. Jika Role Admin/Superadmin, bebaskan saja (biar gak kekunci sendiri)
            if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin') {
                return $next($request);
            }

            // 3. Jika Role Siswa dan BELUM AKTIF (is_active = 0)
            if (!Auth::user()->is_active) {
                
                // Agar tidak redirect loop, cek apakah dia sedang membuka halaman approval
                if ($request->routeIs('approval.notice')) {
                    return $next($request);
                }

                // Lempar ke halaman approval
                return redirect()->route('approval.notice');
            }
        }

        return $next($request);
    }
}