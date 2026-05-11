<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Kelas</h2>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Nama Kelas</p>
                    <p class="font-semibold">{{ $this->record->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Mata Pelajaran</p>
                    <p class="font-semibold">{{ $this->record->subject->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Semester</p>
                    <p class="font-semibold">{{ $this->record->semester->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Ustad</p>
                    <p class="font-semibold">{{ $this->record->teacher->name ?? 'Belum ditentukan' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
