<div class="grid lg:grid-cols-3 gap-5 lg:gap-8">

    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="text-primary">
                <x-icon name="o-shopping-cart" class="w-9 h-9" />
            </div>
            <div>
                <div class="text-xs text-base-content/50">Total ventas</div>
                <div class="font-black text-xl">{{ $totalSales }}</div>
            </div>
        </div>
    </x-card>

    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="text-primary">
                <x-icon name="o-banknotes" class="w-9 h-9" />
            </div>
            <div>
                <div class="text-xs text-base-content/50">Ingresos totales</div>
                <div class="font-black text-xl">
                    ${{ number_format($totalIncome, 2) }}
                </div>
            </div>
        </div>
    </x-card>

    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="text-primary">
                <x-icon name="o-wallet" class="w-9 h-9" />
            </div>
            <div>
                <div class="text-xs text-base-content/50">Ticket promedio</div>
                <div class="font-black text-xl">
                    ${{ number_format($avgTicket, 2) }}
                </div>
            </div>
        </div>
    </x-card>

</div>
