<div class="flex flex-col h-full bg-base-200">

    <!-- Header del sidebar -->
    <div class="sticky top-0 px-4 flex items-center justify-between">
        <label for="main-drawer" class="lg:hidden mr-3 cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>

        <x-button :link="route('welcome')" class="btn btn-ghost btn-circle p-1 btn-xl">
            <img src="{{ asset('favicon.svg') }}" alt="Logo">
        </x-button>

        <div class="text-xl font-bold">Ximenabags</div>
    </div>

    <!-- Menú principal: ocupa el espacio disponible -->
    <x-menu activate-by-route class="flex-1 overflow-y-auto px-2 py-3">
        @auth
            <x-menu-item title="Dashboard" icon="o-home" :link="route('dashboard')" />
            <x-menu-sub title="Almacen" icon="o-building-storefront">
                <x-menu-item title="Venta" icon="o-currency-dollar" :link="route('sales.index')" />
                <x-menu-item title="Registro de ventas" icon="o-currency-dollar" :link="route('sales-counts.index')" />
            </x-menu-sub>
            @if (auth()->check() && auth()->user()->isManager())
                <x-menu-item title="Usuarios" icon="o-user-group" :link="route('usuarios.index')" />

                <x-menu-sub title="Almacen" icon="o-building-storefront">
                    <x-menu-item title="Productos" icon="o-shopping-bag" :link="route('products.index')" />
                    <x-menu-item title="Marcas" icon="o-percent-badge" :link="route('brands.index')" />
                    <x-menu-item title="Categorías" icon="o-tag" :link="route('product-types.index')" />
                </x-menu-sub>
            @endif
        @endauth
    </x-menu>

    <!-- Bloque inferior fijo: login / register -->
    <div class="border-t border-base-300 px-4 py-3 mt-auto">
        @auth
            <!-- Avatar -->
            <x-popover hover>
                <x-slot:trigger>
                    <div class="flex items-center gap-2 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-base-300 flex items-center justify-center">
                            <x-icon name="o-user" class="w-5 h-5" />
                        </div>
                        <span class="text-sm hidden sm:inline font-bold">
                            {{ auth()->user()->name }}
                        </span>
                    </div>
                </x-slot:trigger>

                <x-slot:content>
                    <livewire:auth.logout />
                </x-slot:content>
            </x-popover>
        @else
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-primary">Ingresar</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline">Registrarse</a>
            @endif
        @endauth
    </div>

</div>
