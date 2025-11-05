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
        <x-menu-item title="Home" icon="o-home" link="#" />
        <x-menu-item title="Messages" icon="o-envelope" link="#" />

        <x-menu-sub title="Settings" icon="o-cog-6-tooth">
            <x-menu-item title="Wifi" icon="o-wifi" link="#" />
            <x-menu-item title="Archives" icon="o-archive-box" link="#" />
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
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline w-full">Ingresar</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary w-full">Registrarse</a>
                @endif
            </div>
        @endauth
    </div>

</div>
