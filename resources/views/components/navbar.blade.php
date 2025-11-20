<nav class="sticky top-0 z-50 bg-base-100 shadow px-4 flex items-center justify-between flex-wrap">
    <div class="flex items-center gap-5">
        <label for="main-drawer" class="lg:hidden mr-3 cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>

        <x-button :link="route('welcome')" class="btn btn-ghost btn-circle p-1 btn-xl">
            <img src="{{ asset('favicon.svg') }}" alt="Logo">
        </x-button>
        
        <div class="text-xl font-bold">Ximenabags</div>
    </div>

    <div class="flex items-center gap-2 flex-wrap justify-end w-auto lg:w-auto">
        <div class="hidden lg:flex items-center gap-4">
            <x-menu activate-by-route class="flex-row gap-4">
                <div class="invisible">
                    <x-dropdown label="The man who sold the world" class="btn-ghost font-bold"
                        icon="o-eye-slash">
                    </x-dropdown>
                </div>
                @auth
                    <x-menu-item title="Dashboard" icon="o-home" class="font-bold" :link="route('dashboard')" />
                    <x-menu-item title="Venta" icon="o-currency-dollar" class="font-bold" :link="route('sales.index')" />
                    @if (auth()->check() && auth()->user()->isManager())
                        <x-menu-item title="Usuarios" icon="o-user-group" class="font-bold" :link="route('usuarios.index')" />

                        <x-dropdown label="Almacen" class="btn-ghost font-bold" icon="o-building-storefront">
                            <x-menu-item title="Productos" icon="o-shopping-bag" :link="route('products.index')" />
                            <x-menu-item title="Marcas" icon="o-percent-badge" :link="route('brands.index')" />
                            <x-menu-item title="Categorías" icon="o-tag" :link="route('product-types.index')" />
                        </x-dropdown>
                    @endif
                @endauth
            </x-menu>
        </div>

        <x-theme-toggle class="btn btn-circle btn-ghost" darkTheme="coffee" lightTheme="valentine" />

        <div class="hidden lg:flex items-center gap-2">
            @auth

                <!-- POPOVER MARIUI (SIN AVATAR) -->
                <x-popover hover>
    <x-slot:trigger>
        <div class="flex items-center gap-2 cursor-pointer">
            {{-- Avatar con imagen o imagen por defecto --}}
            <img 
                src="{{ auth()->user()->avatar 
                        ? Storage::url(auth()->user()->avatar) 
                        : asset('storage/products/avatar.png') }}"
                class="w-8 h-8 rounded-full object-cover"
                alt="avatar"
            >

            {{-- Texto Hola, nombre --}}
            <span class="text-sm hidden sm:inline">
                Hola, {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot:trigger>

    <x-slot:content>
        Nombre: {{ auth()->user()->name }} <br>
        Email: {{ auth()->user()->email }}
    </x-slot:content>
</x-popover>

                <livewire:auth.logout />

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
</nav>
