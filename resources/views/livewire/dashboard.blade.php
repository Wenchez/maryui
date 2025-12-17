<div class="w-full">
    <x-header title="Panel de control" subtitle="Reportes e información general" separator>
        <x-slot:middle class="justify-end!">
            <livewire:reports.filters />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:reports.export-reports />
        </x-slot:actions>
    </x-header>

    <livewire:reports.summary-cards />
    <livewire:reports.charts />
    <livewire:reports.lists />
</div>
