<div class="grid lg:grid-cols-2 gap-8 mt-8">
    <!-- Ingresos por mes -->
    <div>
        <x-card class="bg-base-100 rounded-lg p-5 shadow-xs">
            <div class="text-xl font-bold pb-5">Ingresos por mes</div>
            <div class="w-full h-80">
                <x-chart wire:model="incomeByMonthChart" class="w-full h-full" />
            </div>
        </x-card>
    </div>

    <!-- Top usuarios -->
    <div>
        <x-card class="bg-base-100 rounded-lg p-5 shadow-xs">
            <div class="text-xl font-bold pb-5">Mayores vendedores</div>
            <div class="w-full h-80">
                <x-chart wire:model="topUsersChart" class="w-full h-full" />
            </div>
        </x-card>
    </div>
</div>
