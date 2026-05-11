<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Components\Tab; 
use Illuminate\Database\Eloquent\Builder; 

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Data Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->description('Masukkan data dasar pengguna.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('role')
                            ->options([
                                'superadmin' => 'Super Admin (Developer)',
                                'admin' => 'Admin (Ustad)',
                                'student' => 'Siswa (Santri)',
                            ])
                            ->required()
                            ->reactive(), // Agar form bisa berubah sesuai pilihan
                    ])->columns(2),

                Forms\Components\Section::make('Data Tambahan')
                    ->description('Wajib diisi jika role adalah Siswa.')
                    ->schema([
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN')
                            ->numeric()
                            // Hanya muncul jika role = student
                            ->visible(fn (Forms\Get $get) => $get('role') === 'student'),

                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ]),
                            
                        Forms\Components\TextInput::make('phone')
                            ->label('No. HP / WA')
                            ->tel(),
                            
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Akun Aktif?')
                            ->default(true)
                            ->helperText('Jika dimatikan, user tidak bisa login.'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'admin' => 'warning',
                        'student' => 'success',
                    }),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                    
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'superadmin' => 'Superadmin',
                        'admin' => 'Ustad',
                        'student' => 'Siswa',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Pengguna'),
            
            'new_registrants' => Tab::make('Pendaftar Baru')
                ->icon('heroicon-o-user-plus')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'student')->where('is_active', false))
                ->badge(User::where('role', 'student')->where('is_active', false)->count())
                ->badgeColor('danger'), // Merah biar eye-catching

            'active_students' => Tab::make('Siswa Aktif')
                ->icon('heroicon-o-academic-cap')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'student')->where('is_active', true)),
                
            'teachers' => Tab::make('Ustad & Admin')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', '!=', 'student')),
        ];
    }
}