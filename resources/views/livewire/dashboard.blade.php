<div class="w-full">
    <x-header title="Panel de control" subtitle="Reportes e información general" separator>
        <x-slot:actions>
            <livewire:reports.export-reports />
        </x-slot:actions>
    </x-header>

    <livewire:reports.filters />

    <livewire:reports.summary-cards />
    <livewire:reports.charts />
    <livewire:reports.lists />
</div>
