<x-layouts.app>
    <div class="text-center mt-24">
        <h1 class="text-4xl font-bold mb-6">Bienvenido a Ximenabags</h1>
        <p class="mb-6">Regístrate o ingresa para explorar nuestra tienda.</p>

        <div class="flex justify-center gap-4">
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Registrarse</a>
            @endif
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Ingresar</a>
            @endif
        </div>
    </div>
</x-layouts.app>