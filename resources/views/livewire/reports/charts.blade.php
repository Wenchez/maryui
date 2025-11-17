<div class="grid lg:grid-cols-2 gap-8 mt-8">
    <!-- Ingresos por mes -->
    <div>
        <x-card title="Ingresos por mes" class="bg-base-100 rounded-lg p-5 shadow-xs">
            <x-slot:menu>
                <x-button title="Ventas" icon="o-currency-dollar" :link="route('sales.index')" tooltip="Ventas" />
            </x-slot:menu>
            <div class="w-full h-80">
                <x-chart wire:model="incomeByMonthChart" class="w-full h-full" />
            </div>
        </x-card>
    </div>

    <!-- Top usuarios -->
    <div>
        <x-card title="Mayores vendedores" class="bg-base-100 rounded-lg p-5 shadow-xs">
            <x-slot:menu>
                <x-button title="Usuarios" icon="o-user-group" :link="route('usuarios.index')" tooltip="Usuarios" />
            </x-slot:menu>
            <div class="w-full h-80">
                <x-chart wire:model="topUsersChart" class="w-full h-full" />
            </div>
        </x-card>
    </div>
</div>
