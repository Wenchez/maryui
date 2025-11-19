<div class="w-full text-white flex items-center justify-center">
    <div class="flex flex-col items-center justify-center gap-6 text-center">

        {{-- Ícono grande y rojo --}}
        <div class="text-9xl animate-pulse text-red-600 mb-5">
            &#9888;
        </div>

        {{-- Mensaje dramático --}}
        <h1 class="text-5xl font-extrabold uppercase tracking-wide text-red-700 animate-bounce">
            Acceso Denegado
        </h1>
        <p class="text-xl text-red-500 max-w-xl font-bold">
            ¡Alerta! Has intentado entrar a un área prohibida.
        </p>

        {{-- Botón de escape --}}
        <x-button color="error" class="btn btn-xs sm:btn-sm md:btn-md lg:btn-lg xl:btn-xl hover:scale-105 transition-transform duration-300"
            :link="route('dashboard')">
            Huir al Dashboard
        </x-button>

    </div>
</div>
