<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RolePermissionResource\Pages;
use App\Models\RolePermission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RolePermissionResource extends Resource
{
    protected static ?string $model = RolePermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Hak Akses Role';

    protected static ?string $navigationGroup = 'Manajemen Akses';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options(RolePermission::ROLES)
                    ->required()
                    ->native(false),

                Forms\Components\Select::make('permission')
                    ->label('Permission')
                    ->options(RolePermission::PERMISSIONS)
                    ->required()
                    ->searchable()
                    ->native(false),

                Forms\Components\Toggle::make('is_allowed')
                    ->label('Diizinkan')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => RolePermission::ROLES[$state] ?? $state),

                Tables\Columns\TextColumn::make('permission')
                    ->label('Permission')
                    ->formatStateUsing(fn (string $state): string => RolePermission::PERMISSIONS[$state] ?? $state)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_allowed')
                    ->label('Diizinkan')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(RolePermission::ROLES),

                Tables\Filters\TernaryFilter::make('is_allowed')
                    ->label('Diizinkan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(fn (RolePermission $record) => static::clearPermissionCache($record)),
                Tables\Actions\DeleteAction::make()
                    ->after(fn (RolePermission $record) => static::clearPermissionCache($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('role', array_keys(RolePermission::ROLES));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRolePermissions::route('/'),
            'create' => Pages\CreateRolePermission::route('/create'),
            'edit' => Pages\EditRolePermission::route('/{record}/edit'),
        ];
    }

    protected static function clearPermissionCache(RolePermission $record): void
    {
        cache()->forget($record->cacheKey());
    }
}
