<nav class="sticky top-0 z-50 bg-base-100 shadow px-4 py-2 flex items-center justify-between">
    <div class="flex items-center gap-5">
        <label for="main-drawer" class="lg:hidden mr-3 cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <div class="text-xl font-bold">Ximenabags</div>
    </div>

    <div class="flex items-center gap-2">
        <div class="hidden lg:flex items-center gap-4">
            <x-dropdown label="Settings" icon="o-cog-6-tooth" class="btn-ghost">
                <x-menu-item title="Wifi" icon="o-wifi" link="#" />
                <x-menu-item title="Archives" icon="o-archive-box" link="#" />
            </x-dropdown>
            <x-button label="Home" icon="o-home" link="#" class="btn-ghost" responsive />
            <x-button label="Messages" icon="o-envelope" link="#" class="btn-ghost" responsive />
        </div>

        <x-theme-toggle class="btn btn-circle btn-ghost" darkTheme="dark" lightTheme="caramellatte" />

        @auth
            <span class="text-sm hidden sm:inline">Hola, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost">Cerrar sesión</button>
            </form>
            @else
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-ghost">Ingresar</a>
            @endif
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-ghost">Registrarse</a>
            @endif
        @endauth
    </div>
</nav>