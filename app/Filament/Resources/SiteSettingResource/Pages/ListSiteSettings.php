<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('manage-spmb')
                ->label('⏱️ Atur Deadline SPMB')
                ->icon('heroicon-o-calendar-days')
                ->url(static::getResource()::getUrl('manage-spmb'))
                ->button()
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
