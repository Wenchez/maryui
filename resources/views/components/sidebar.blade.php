<div class="flex flex-col h-full bg-base-200">

    <!-- Header del sidebar -->
    <div class="sticky top-0 px-4 flex items-center justify-between">
        <label for="main-drawer" class="lg:hidden mr-3 cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>

        <x-button :link="route('dashboard')" class="btn btn-ghost btn-circle p-1 btn-xl">
            <img src="{{ asset('favicon.svg') }}" alt="Logo">
        </x-button>
        
        <div class="text-xl font-bold">Ximenabags</div>
    </div>

    <!-- Menú principal: ocupa el espacio disponible -->
    <x-menu activate-by-route class="flex-1 overflow-y-auto px-2 py-3">
        @auth
            <x-menu-item title="Dashboard" icon="o-home" :link="route('dashboard')" />
            <x-menu-item title="Venta" icon="o-currency-dollar" :link="route('sales.index')" />
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
            <div class="flex flex-col gap-2">
                <span class="text-sm text-base-content/80 truncate">Hola, {{ auth()->user()->name }}</span>
                <livewire:auth.logout />
            </div>
        @else
            <div class="flex flex-col gap-2">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary w-full">Ingresar</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline w-full">Registrarse</a>
                @endif
            </div>
        @endauth
    </div>

</div>
