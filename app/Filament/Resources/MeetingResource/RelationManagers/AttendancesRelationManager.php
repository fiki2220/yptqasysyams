<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $title = 'Daftar Hadir Santri';

    protected static ?string $recordTitleAttribute = 'status';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Santri')
                    ->options(User::where('role', 'student')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                    
                Forms\Components\Select::make('status')
                    ->options([
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permission' => 'Izin',
                        'alpha' => 'Tanpa Keterangan',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Santri')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('student.nisn')
                    ->label('NISN')
                    ->sortable(),

                // SelectColumn agar bisa edit langsung di tabel tanpa buka form
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permission' => 'Izin',
                        'alpha' => 'Alpha',
                    ])
                    ->selectablePlaceholder(false),
            ])
            ->headerActions([
                // ACTION SAKTI: Generate Data Otomatis
                Tables\Actions\Action::make('ambil_data_santri')
                    ->label('Ambil Data Semua Santri')
                    ->icon('heroicon-o-users')
                    ->color('success')
                    ->action(function () {
                        // 1. Ambil Meeting ID saat ini
                        $meeting = $this->getOwnerRecord();
                        
                        // 2. Ambil semua siswa aktif
                        $students = User::where('role', 'student')
                            ->where('is_active', true)
                            ->get();

                        $count = 0;
                        foreach ($students as $student) {
                            // 3. Cek apakah sudah ada di absen? Kalau belum, buatkan.
                            $exists = $meeting->attendances()->where('user_id', $student->id)->exists();
                            
                            if (!$exists) {
                                $meeting->attendances()->create([
                                    'user_id' => $student->id,
                                    'status' => 'alpha', // Default Alpha, nanti ustad tinggal ganti jadi Hadir
                                ]);
                                $count++;
                            }
                        }

                        Notification::make()
                            ->title("Berhasil menambahkan $count santri ke daftar hadir.")
                            ->success()
                            ->send();
                    }),
                
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Manual'),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk update status (Misal: Set Semua Hadir)
                    Tables\Actions\BulkAction::make('set_hadir')
                        ->label('Set Semua Hadir')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update(['status' => 'present'])), 
                ]),
            ]);
    }
}