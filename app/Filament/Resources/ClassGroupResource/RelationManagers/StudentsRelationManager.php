<?php

namespace App\Filament\Resources\ClassGroupResource\RelationManagers;

// INI ADALAH BARIS YANG MEMPERBAIKI ERROR SEBELUMNYA
use App\Filament\Resources\AssessmentResource; 

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentsRelationManager extends RelationManager
{
    // Ini menyesuaikan nama fungsi relasi di model ClassGroup
    protected static string $relationship = 'students'; 

    // Mengubah judul tabel di halaman
    protected static ?string $title = 'Daftar Santri';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form ini digunakan jika kamu ingin mengedit data pivot di masa depan
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // recordTitleAttribute wajib diisi agar dropdown Filament tahu kolom apa yang ditampilkan
            ->recordTitleAttribute('name') 
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),

                // Menampilkan data pivot (kapan dia bergabung)
                Tables\Columns\TextColumn::make('joined_at')
                    ->label('Tanggal Bergabung')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // INI KUNCINYA: AttachAction untuk memunculkan dropdown tambah santri yang sudah ada
                Tables\Actions\AttachAction::make()
                    ->label('+ Tambah Santri')
                    ->preloadRecordSelect() // Memuat opsi agar dropdown bisa langsung di-search
                    
                    // Filter agar yang muncul di dropdown HANYA user dengan role 'student'
                    ->recordSelectOptionsQuery(fn (Builder $query) => $query->where('role', 'student'))
                    
                    // Custom form untuk memasukkan data pivot tambahan (joined_at)
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Pilih Santri')
                            ->required(),
                            
                        // Otomatis mengisi kolom joined_at di tabel pivot
                        Forms\Components\Hidden::make('joined_at')
                            ->default(now()),
                    ])
                    ->successNotificationTitle('Santri berhasil ditambahkan ke kelas!'),
            ])
            ->actions([
                // Action untuk melihat penilaian (Sudah terhubung dengan AssessmentResource)
                Tables\Actions\Action::make('lihat_penilaian')
                    ->label('Lihat Penilaian')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => AssessmentResource::getUrl('index', [
                        // Mengirim parameter filter ke halaman daftar penilaian
                        'tableFilters' => [
                            'user_id' => ['value' => $record->id], 
                            'class_group_id' => ['value' => $this->getOwnerRecord()->id],
                        ]
                    ])),

                // Action untuk mengeluarkan santri dari kelas (Detach)
                Tables\Actions\DetachAction::make()
                    ->label('Keluarkan')
                    ->successNotificationTitle('Santri dikeluarkan dari kelas.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Keluarkan yang dipilih'),
                ]),
            ]);
    }
}