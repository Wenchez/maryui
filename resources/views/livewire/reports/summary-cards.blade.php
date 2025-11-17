<div class="grid lg:grid-cols-4 gap-5 lg:gap-8">
    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs truncate text-ellipsis">
        <div class="flex items-center gap-3">
            <div class="text-primary">
                <x-icon name="o-banknotes" class="w-9 h-9" />
            </div>
            <div class="text-left">
                <div class="text-xs text-base-content/50 whitespace-nowrap">Total últimos 30 días</div>
                <div class="font-black text-xl">${{ number_format($incomeLast30, 2) }}</div>
            </div>
        </div>
    </x-card>

    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="text-primary">
                <x-icon name="o-shopping-cart" class="w-9 h-9" />
            </div>
            <div class="text-left">
                <div class="text-xs text-base-content/50 whitespace-nowrap">Ventas este mes</div>
                <div class="font-black text-xl">{{ $salesThisMonth }}</div>
            </div>
        </div>
    </x-card>

    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="text-primary">
                <x-icon name="o-wallet" class="w-9 h-9" />
            </div>
            <div class="text-left">
                <div class="text-xs text-base-content/50 whitespace-nowrap">Ingreso este mes</div>
                <div class="font-black text-xl">${{ number_format($incomeThisMonth, 2) }}</div>
            </div>
        </div>
    </x-card>

    <x-card class="bg-base-300 rounded-lg px-5 py-4 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="text-pink-500">
                <x-icon name="o-gift" class="w-9 h-9" />
            </div>
            <div class="text-left">
                <div class="text-xs text-base-content/50 whitespace-nowrap">Productos vendidos este mes</div>
                <div class="font-black text-xl">{{ $productsSoldThisMonth }}</div>
            </div>
        </div>
    </x-card>
</div>
