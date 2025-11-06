<div class="flex flex-col h-full bg-base-200">

    <!-- Header del sidebar -->
    <div class="sticky top-0 px-4 py-3 flex items-center justify-between">
        <div class="text-xl font-bold">Ximenabags</div>
        <label for="main-drawer" class="cursor-pointer btn btn-ghost btn-circle">
            <x-icon name="o-x-mark" class="w-6 h-6" />
        </label>
    </div>

    <!-- Menú principal: ocupa el espacio disponible -->
    <x-menu activate-by-route class="flex-1 overflow-y-auto px-2 py-3">
        <x-menu-item title="Dashboard" icon="o-home" :link="route('dashboard')" />
        <x-menu-item title="Usuarios" icon="o-user-group" :link="route('usuarios.index')" />
        <x-menu-item title="Venta" icon="o-currency-dollar" link="#" />
        <x-menu-item title="Reportes" icon="o-document-currency-dollar" link="#" />

        <x-menu-sub title="Almacen" icon="o-building-storefront">
            <x-menu-item title="Productos" icon="o-shopping-bag" link="#" />
            <x-menu-item title="Marcas" icon="o-percent-badge" link="#" />
            <x-menu-item title="Categorías" icon="o-tag" link="#" />
        </x-menu-sub>
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
