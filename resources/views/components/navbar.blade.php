<nav class="sticky top-0 z-50 bg-base-100 shadow px-4 py-2 flex items-center justify-between flex-wrap">
    <div class="flex items-center gap-5">
        <label for="main-drawer" class="lg:hidden mr-3 cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <div class="text-xl font-bold">Ximenabags</div>
    </div>

    <div class="flex items-center gap-2 flex-wrap justify-end w-auto lg:w-auto">
        <div class="hidden lg:flex items-center gap-4">
            <x-menu activate-by-route class="flex-row gap-4">
                <x-menu-item title="Usuarios" icon="o-user-group" link="#" />
                <x-menu-item title="Venta" icon="o-currency-dollar" link="#" />
                <x-menu-item title="Reportes" icon="o-document-currency-dollar" link="#" />
                <x-dropdown label="Almacen" class="btn-ghost" icon="o-building-storefront">
                    <x-menu-item title="Productos" icon="o-wifi" link="#" />
                    <x-menu-item title="Marcas" icon="o-percent-badge" link="#" />
                    <x-menu-item title="Categorías" icon="o-tag" link="#" />
                </x-dropdown>
            </x-menu>
        </div>

        <x-theme-toggle class="btn btn-circle btn-ghost" darkTheme="coffee" lightTheme="caramellatte" />

        <div class="hidden lg:flex items-center gap-2">
            @auth
                <span class="text-sm hidden sm:inline">Hola, {{ auth()->user()->name }}</span>
                <livewire:auth.logout />
            @else
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary">Ingresar</a>
                @endif
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline">Registrarse</a>
                @endif
            @endauth
        </div>
    </div>
</nav>
