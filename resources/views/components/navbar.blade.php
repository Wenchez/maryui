<nav class="sticky top-0 z-50 bg-base-100 shadow px-4 py-2 flex items-center justify-between flex-wrap">
    <div class="flex items-center gap-5">
        <label for="main-drawer" class="lg:hidden mr-3 cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <div class="text-xl font-bold">Ximenabags</div>
    </div>

    <div class="flex items-center gap-2 flex-wrap justify-end w-auto lg:w-auto">
        <div class="hidden lg:flex items-center gap-4">
            <x-dropdown label="Settings" icon="o-cog-6-tooth" class="btn-ghost">
                <x-menu-item title="Wifi" icon="o-wifi" link="#" />
                <x-menu-item title="Archives" icon="o-archive-box" link="#" />
            </x-dropdown>
            <x-button label="Home" icon="o-home" link="#" class="btn-ghost" responsive />
            <x-button label="Messages" icon="o-envelope" link="#" class="btn-ghost" responsive />
        </div>

        <x-theme-toggle class="btn btn-circle btn-ghost" darkTheme="dark" lightTheme="caramellatte" />

        <div class="hidden lg:flex items-center gap-2">
            @auth
                <span class="text-sm hidden sm:inline">Hola, {{ auth()->user()->name }}</span>
                <livewire:auth.logout />
            @else
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-ghost">Ingresar</a>
                @endif
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-ghost">Registrarse</a>
                @endif
            @endauth
        </div>
    </div>
</nav>
