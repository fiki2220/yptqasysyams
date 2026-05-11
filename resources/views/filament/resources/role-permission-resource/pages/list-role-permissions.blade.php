<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <x-filament-actions::modals />

        <div class="flex justify-end">
            <x-filament::button type="submit">
                Simpan Hak Akses
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
