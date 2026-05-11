<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectUnauthorizedFilamentAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->role === 'superadmin') {
            return $next($request);
        }

        if ($user->role === 'student') {
            return redirect()->route('dashboard');
        }

        if ($user->role !== 'guru') {
            return redirect()->route('access.denied');
        }

        $permission = $this->permissionForRoute($request->route()?->getName());

        if ($permission && $user->hasAccess($permission)) {
            return $next($request);
        }

        return $this->redirectToAllowedPage($user, $request);
    }

    private function permissionForRoute(?string $routeName): ?string
    {
        if (! $routeName || $routeName === 'filament.admin.home') {
            return null;
        }

        return match (true) {
            str_contains($routeName, '.resources.candidates.') => 'spmb.manage',
            str_contains($routeName, '.resources.class-groups.') => 'classes.manage',
            str_contains($routeName, '.resources.meetings.') => 'meetings.manage',
            str_contains($routeName, '.resources.assessments.') => 'assessments.manage',
            str_contains($routeName, '.resources.evaluations.') => 'evaluations.manage',
            str_contains($routeName, '.resources.grades.') => 'grades.manage',
            str_contains($routeName, '.resources.payments.') => 'payments.manage',
            str_contains($routeName, '.resources.posts.') => 'posts.manage',
            str_contains($routeName, '.resources.site-settings.') => 'settings.manage',
            str_contains($routeName, '.resources.raport.') => 'reports.view',
            str_contains($routeName, '.resources.users.') => 'users.manage',
            str_contains($routeName, '.resources.role-permissions.') => 'superadmin.only',
            default => null,
        };
    }

    private function redirectToAllowedPage($user, Request $request): Response
    {
        $fallback = $user->getFirstAllowedFilamentRoute();

        if ($fallback && $fallback !== $request->fullUrl()) {
            return redirect()->to($fallback);
        }

        return redirect()->route('access.denied');
    }
}
