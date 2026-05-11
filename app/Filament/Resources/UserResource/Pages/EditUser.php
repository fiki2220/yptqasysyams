<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! UserResource::canManageActivation($this->record)) {
            $data['is_active'] = $this->record->is_active;
        }

        if ($this->record->id === auth()->id() && $this->record->role === 'superadmin') {
            $data['role'] = $this->record->role;
        }

        if (auth()->user()?->role !== 'superadmin' && $this->record->role === 'superadmin') {
            $data['role'] = $this->record->role;
            $data['is_active'] = $this->record->is_active;
        }

        return $data;
    }
}
