<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->hasAccess($permission)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }

        if ($user->role === 'student') {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki hak akses untuk membuka halaman tersebut.');
        }

        $fallback = $user->getFirstAllowedFilamentRoute();

        if ($fallback) {
            return redirect($fallback)
                ->with('error', 'Hak akses Anda tidak mengizinkan membuka halaman tersebut.');
        }

        return redirect()->route('access.denied');
    }
}