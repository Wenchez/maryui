<div class="w-full">
    <x-header title="Registros de ventas" subtitle="Información especifica de ventas" separator>
        <x-slot:actions>
            <livewire:reports.export-reports />
        </x-slot:actions>
    </x-header>

    <livewire:sales-counts.sales-summary-cards />
    <livewire:sales-counts.sales-filters />
    <livewire:sales-counts.sales-lists />
</div>
