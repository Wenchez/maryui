<div class="p-6 space-y-6  min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-extrabold">Dashboard</h1>
            <p class="mt-1">Bienvenido a Ximenabags</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition">Nuevo Pedido</button>
            <div class="text-sm text-gray-500">Últimos 30 días</div>
        </div>
    </div>

    <!-- Top stat cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <x-stat
                title="Ingresos"
                value="$477,043"
                icon="o-arrow-trending-up"
                tooltip="Últimos 30 días"
                color="text-emerald-600" />
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <x-stat
                title="Pedidos"
                description="Este mes"
                value="100"
                icon="o-shopping-cart"
                tooltip="Pedidos totales" />
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <x-stat
                title="Clientes Nuevos"
                description="Este mes"
                value="62"
                icon="o-user-group"
                tooltip="Nuevos clientes" />
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <x-stat
                title="Cancelados"
                description="Este mes"
                value="8"
                icon="o-x-mark"
                color="text-red-500"
                tooltip="Pedidos cancelados" />
        </div>
    </div>

    <!-- Main charts area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-8 shadow-md flex flex-col justify-center items-center min-h-[420px]">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 w-full text-center">Ingresos</h2>
            <x-chart wire:model="incomeChart" class="w-full h-[350px]" />
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-900 w-full text-center">Categorías</h2>
                <div class="flex gap-2">
                    <x-button label="Aleatorizar" wire:click="randomizeChart" icon="o-arrow-path" class="btn-sm btn-ghost" spinner />
                    <x-button label="Cambiar" wire:click="switchChartType" icon="o-arrows-right-left" class="btn-sm btn-ghost" spinner />
                </div>
            </div>
            <x-chart wire:model="categoryChart" class="w-full h-[350px]" />
        </div>
    </div>

    <!-- Bottom lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Clientes Principales</h3>
                <a class="text-sm text-emerald-600 hover:text-emerald-700 font-medium" href="#">Ver todos →</a>
            </div>
            <div class="space-y-4">
                @php
                    $customers = [
                        ['name' => 'Carla Medina', 'country' => 'Constitucion', 'value' => '$30,589.00'],
                        ['name' => 'Diego Cepeda', 'country' => 'La Paz', 'value' => '$23,015.00'],
                        ['name' => 'Diego Peñuelas', 'country' => 'Constitucion', 'value' => '$20,744.00'],
                    ];
                @endphp
                @foreach ($customers as $c)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-b-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-sm">{{ substr($c['name'], 0, 1) }}</div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $c['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $c['country'] }}</div>
                            </div>
                        </div>
                        <div class="text-sm bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full border border-emerald-200 font-medium">{{ $c['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Productos Destacados</h3>
                <a class="text-sm text-emerald-600 hover:text-emerald-700 font-medium" href="#">Ver todos →</a>
            </div>
            <div class="space-y-4">
                @php
                    $products = [
                        ['name' => 'Bolsa Premium', 'type' => 'Bolsa', 'qty' => 16],
                        ['name' => 'Cartera Elegante', 'type' => 'Bolsa', 'qty' => 12],
                        ['name' => 'Mochila Casual', 'type' => 'Bolsa', 'qty' => 12],
                    ];
                @endphp
                @foreach ($products as $p)
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 last:border-b-0">
                        <div>
                            <div class="font-medium text-gray-900">{{ $p['name'] }}</div>
                            <div class="text-sm text-gray-500">{{ $p['type'] }}</div>
                        </div>
                        <div class="text-sm text-emerald-700 bg-emerald-50 px-2 py-1 rounded-full border border-emerald-200 font-medium">{{ $p['qty'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
