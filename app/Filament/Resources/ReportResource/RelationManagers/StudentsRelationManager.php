<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';
    protected static ?string $title = 'Daftar Nilai & Kehadiran Santri';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Santri')
                    ->getStateUsing(fn ($record) => $record->name)
                    ->searchable(),

                // Kolom Hadir
                Tables\Columns\TextColumn::make('hadir')
                    ->label('H')
                    ->badge()->color('success')
                    ->getStateUsing(fn ($record) => 
                        $record->attendances()->where('status', 'hadir')
                        ->whereIn('meeting_id', $this->getOwnerRecord()->meetings()->pluck('id'))->count()
                    ),

                // Kolom Sakit
                Tables\Columns\TextColumn::make('sakit')
                    ->label('S')
                    ->badge()->color('info')
                    ->getStateUsing(fn ($record) => 
                        $record->attendances()->where('status', 'sakit')
                        ->whereIn('meeting_id', $this->getOwnerRecord()->meetings()->pluck('id'))->count()
                    ),

                // Kolom Izin
                Tables\Columns\TextColumn::make('izin')
                    ->label('I')
                    ->badge()->color('warning')
                    ->getStateUsing(fn ($record) => 
                        $record->attendances()->where('status', 'izin')
                        ->whereIn('meeting_id', $this->getOwnerRecord()->meetings()->pluck('id'))->count()
                    ),

                // Kolom Alpha
                Tables\Columns\TextColumn::make('alpha')
                    ->label('A')
                    ->badge()->color('danger')
                    ->getStateUsing(fn ($record) => 
                        $record->attendances()->where('status', 'alpha')
                        ->whereIn('meeting_id', $this->getOwnerRecord()->meetings()->pluck('id'))->count()
                    ),

                // Persentase
                Tables\Columns\TextColumn::make('persentase')
                    ->label('% Kehadiran')
                    ->getStateUsing(function ($record) {
                        $total = $this->getOwnerRecord()->meetings()->count();
                        if ($total == 0) return '0%';
                        $hadir = $record->attendances()->where('status', 'hadir')
                            ->whereIn('meeting_id', $this->getOwnerRecord()->meetings()->pluck('id'))->count();
                        return round(($hadir / $total) * 100) . '%';
                    })
            ])
            ->filters([])
            ->headerActions([])
            ->actions([
                Tables\Actions\Action::make('lihat_rapor')
                    ->label('Lihat Raport')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading(fn ($record) => 'Raport Santri: ' . $record->name)
                    ->modalContent(fn ($record) => view('filament.report.rapor-modal', [
                        'student' => $record,
                        'classGroup' => $this->getOwnerRecord()
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
            ])
            ->bulkActions([]);
    }
}