<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class CandidateResource extends Resource
{
    protected static ?string $model = User::class;

    // Setting Tampilan Menu
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Calon Peserta Didik';
    protected static ?string $modelLabel = 'Calon Siswa';
    protected static ?string $pluralModelLabel = 'Calon Peserta Didik';
    protected static ?string $navigationGroup = 'Pendaftaran (PPDB)';
    protected static ?int $navigationSort = 1;

    // FILTER QUERY: Hanya ambil siswa yang BELUM AKTIF
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'student')
            ->where('is_active', false);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Biodata Pendaftar')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->disabled(),
                        
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('phone')
                            ->label('No. HP / WA')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Pendidikan & Keluarga')
                    ->schema([
                        Forms\Components\TextInput::make('grade_level')
                            ->label('Daftar Jenjang')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('school_origin')
                            ->label('Asal Sekolah')
                            ->disabled(),

                        Forms\Components\TextInput::make('gender')
                            ->label('Jenis Kelamin')
                            ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('mother_name')
                            ->label('Nama Ibu Kandung')
                            ->disabled(),
                            
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->disabled(),
                            
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Calon Siswa')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('grade_level')
                    ->label('Jenjang')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'L' ? 'info' : 'pink'),

                Tables\Columns\TextColumn::make('school_origin')
                    ->label('Asal Sekolah')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('mother_name')
                    ->label('Nama Ibu')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Daftar')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                // Bisa tambah filter berdasarkan Jenjang (SD/SMP/SMA)
                Tables\Filters\SelectFilter::make('grade_level')
                    ->options([
                        'SDIT' => 'SDIT',
                        'SMPIT' => 'SMPIT',
                        'SMAIT' => 'SMAIT',
                    ])
                    ->label('Filter Jenjang'),
            ])
            ->actions([
                // VIEW ACTION (Lihat Detail)
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Detail')
                    ->modalHeading('Detail Data Pendaftar'),

                // APPROVE ACTION (Terima Siswa)
                Tables\Actions\Action::make('approve')
                    ->label('Terima Siswa')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Calon Siswa?')
                    ->modalDescription('Siswa akan diaktifkan dan bisa login ke dashboard. Data akan pindah ke menu "Data Pengguna".')
                    ->modalSubmitActionLabel('Ya, Terima')
                    ->action(function (User $record) {
                        // Update status jadi Aktif
                        $record->update(['is_active' => true]);

                        Notification::make()
                            ->title('Siswa Berhasil Diterima')
                            ->body("{$record->name} sekarang sudah bisa login.")
                            ->success()
                            ->send();
                    }),
                    
                // REJECT ACTION (Hapus Pendaftaran)
                Tables\Actions\DeleteAction::make()
                    ->label('Tolak / Hapus')
                    ->requiresConfirmation()
                    ->modalDescription('Apakah Anda yakin ingin menolak dan menghapus data pendaftar ini?'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidates::route('/'),
            // Kita matikan create karena siswa daftar lewat depan (Web)
            // 'create' => Pages\CreateCandidate::route('/create'),
            // 'edit' => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }
}