<?php

namespace App\Filament\Concerns;

use Illuminate\Support\Facades\Auth;

trait ChecksResourcePermission
{
    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }

    public static function canViewAny(): bool
    {
        return static::canAccessAction('view');
    }

    public static function canCreate(): bool
    {
        return static::canAccessAction('create');
    }

    public static function canView($record): bool
    {
        return static::canAccessAction('view');
    }

    public static function canEdit($record): bool
    {
        return static::canAccessAction('update');
    }

    public static function canDelete($record): bool
    {
        return static::canAccessAction('delete');
    }

    public static function canDeleteAny(): bool
    {
        return static::canAccessAction('delete');
    }

    protected static function permission(): string
    {
        return '';
    }

    protected static function canAccessAction(string $action): bool
    {
        $base = static::permissionBase();

        if ($base === '') {
            return false;
        }

        return Auth::user()?->hasAnyAccess([
            "{$base}.{$action}",
            "{$base}.manage",
        ]) ?? false;
    }

    protected static function permissionBase(): string
    {
        return preg_replace('/\.(view|create|update|delete|manage)$/', '', static::permission()) ?? '';
    }
}
