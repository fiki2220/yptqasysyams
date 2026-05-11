<?php

namespace App\Filament\Resources\RolePermissionResource\Pages;

use App\Filament\Resources\RolePermissionResource;
use App\Models\RolePermission;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateRolePermission extends CreateRecord
{
    protected static string $resource = RolePermissionResource::class;

    protected function afterCreate(): void
    {
        /** @var RolePermission $record */
        $record = $this->record;

        Cache::forget("role_permission:{$record->role}:{$record->permission}");
    }
}
