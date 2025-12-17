<div class="w-full">
    <x-header title="Registros de ventas" subtitle="Información especifica de ventas" separator>
        <x-slot:middle class="justify-end!">
        </x-slot:middle>
        <x-slot:actions class="justify-end!">
            <livewire:sales-counts.sales-filters 
            :isCashier="$isCashier" />
        </x-slot:actions>
    </x-header>

    <livewire:sales-counts.sales-summary-cards
    :isCashier="$isCashier" />
    <livewire:sales-counts.sales-lists 
    :isCashier="$isCashier" />
</div>
