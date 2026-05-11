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

        $permissions = array_filter(explode('|', $permission));

        if ($user->hasAnyAccess($permissions)) {
            return $next($request);
        }

        if ($user->role === 'student' && $request->routeIs('dashboard')) {
            return $next($request);
        }

        return $this->redirectSafely($user);
    }

    private function redirectSafely($user): Response
    {
        $fallback = $user->getFirstAllowedFilamentRoute();

        if ($fallback) {
            return redirect()->to($fallback);
        }

        return redirect()->route('access.denied');
    }
}
