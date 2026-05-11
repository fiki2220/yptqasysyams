<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;


    public array $attendanceData = [];

    // Fungsi ini mencegat data form sebelum disimpan ke tabel meetings
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Simpan data absensi sementara
        $this->attendanceData = $data['students_attendance'] ?? [];
        
        // 2. Hapus dari form data agar tidak error "Unknown column" saat menyimpan meeting
        unset($data['students_attendance']);

        return $data;
    }

    // Fungsi ini dijalankan setelah data meeting berhasil tersimpan
    protected function afterCreate(): void
    {
        $meeting = $this->record;
        
        // 3. Simpan data absensi ke tabel attendances
        foreach ($this->attendanceData as $row) {
            $meeting->attendances()->create([
                'user_id' => $row['user_id'],
                'status' => $row['status'],
            ]);
        }
    }

    // Balik ke halaman index setelah selesai
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}