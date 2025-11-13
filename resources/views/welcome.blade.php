<x-layouts.app>
    <main class="max-w-3xl mx-auto px-6 py-16 space-y-12">
        <!-- Hero -->
        <section class="text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">Ximenabags</h1>
            <p class="text-lg text-gray-600 mb-6">Venta de bolsas, carteras , ropa y mas productos 100 % originales a un excelente precio</p>

            <div class="flex flex-col sm:flex-row justify-center gap-3 items-center">
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="inline-block px-6 py-3 border border-emerald-600 text-emerald-600 rounded-md font-medium hover:bg-emerald-50">Ingresar</a>
                @endif
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-block px-6 py-3 border border-emerald-600 text-emerald-600 rounded-md font-medium hover:bg-emerald-50">Registrarse</a>
                @endif
            </div>
        </section>

        @php
            $slides = [
                ['image' => '/photos/WhatsApp Image 2025-11-11 at 11.01.44 PM (2).jpeg'],
                ['image' => '/photos/WhatsApp Image 2025-11-11 at 11.01.44 PM.jpeg'],
                ['image' => '/photos/WhatsApp Image 2025-11-11 at 11.01.44 PM (1).jpeg'],
                ['image' => '/photos/WhatsApp Image 2025-11-12 at 12.38.51 AM.jpeg'],
            ];
        @endphp

        <x-carousel :slides="$slides" />

        <!-- Características -->
        <section class="rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-center">Por qué elegirnos</h2>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">⭐</div>
                    <div>
                        <h3 class="font-medium">Calidad superior</h3>
                        <p class="text-sm text-gray-600">Materiales premium y acabados pensados para durar.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">🚚</div>
                    <div>
                        <h3 class="font-medium">Ventas Confiables</h3>
                        <p class="text-sm text-gray-600">Envíos confiables y seguimiento en todas las órdenes.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">🔁</div>
                    <div>
                        <h3 class="font-medium">Garantía y devolución</h3>
                        <p class="text-sm text-gray-600">Política clara de devolución y atención personalizada.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Colecciones destacadas -->
        <section>
            <h2 class="text-2xl font-semibold mb-6 text-center">Colecciones</h2>
            
            <!-- Colección Primavera -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Colecciones Femaninas</h3>
                <p class="text-sm text-gray-600 mb-4">Colores vibrantes y diseños frescos para la temporada.</p>
                @php
                    $slidesPrimavera = [
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 10.40.43 PM (5).jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.19 PM.jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.19 PM (2).jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 10.40.43 PM (3).jpeg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesPrimavera" class="h-90!"/>
            </div>

            <!-- Colección Clásicos -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Colecciones Masculinas</h3>
                <p class="text-sm text-gray-600 mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.20 PM.jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.19 PM (4).jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.19 PM (3).jpeg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" />
            </div>

            <!-- Colección Bolsos -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Coleccion de Bolsos</h3>
                <p class="text-sm text-gray-600 mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.19 PM (2).jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 3.55.19 PM (1).jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 10.40.43 PM (2).jpeg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" />
            </div>

            <!-- Colección Accesorios -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Coleccion de Accesorios</h3>
                <p class="text-sm text-gray-600 mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 10.40.43 PM.jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 10.40.43 PM (4).jpeg'],
                        ['image' => '/photos/WhatsApp Image 2025-11-11 at 10.40.43 PM (1).jpeg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" />
            </div>

        </section>

        <!-- Ofertas especiales -->
        <section class=" p-6 rounded-lg">
            <h2 class="text-2xl font-semibold mb-2">Ofertas especiales</h2>
            <p class="text-sm text-gray-700 mb-4">Descuentos por tiempo limitado en selecciones exclusivas.</p>
            <div class="grid grid-cols-1 gap-3">
                <div class="flex items-center justify-between bg-white p-3 rounded border">
                    <div>
                        <div class="font-medium">Bolso "Luna" — 20% OFF</div>
                        <div class="text-sm text-gray-600">Perfecto para el día a día.</div>
                    </div>
                    <div class="text-emerald-600 font-semibold">$79</div>
                </div>
                <div class="flex items-center justify-between bg-white p-3 rounded border">
                    <div>
                        <div class="font-medium">Clutch "Noche" — 15% OFF</div>
                        <div class="text-sm text-gray-600">Elegancia compacta para salir.</div>
                    </div>
                    <div class="text-emerald-600 font-semibold">$49</div>
                </div>
            </div>
        </section>

        <!-- Testimonios -->
        <section>
            <h2 class="text-2xl font-semibold mb-4">Lo que dicen nuestros clientes</h2>
            <div class="space-y-3">
                <blockquote class="border-l-4 border-emerald-200 pl-4 text-gray-700">"Recibí mi bolso en 2 días y la calidad es fantástica. Volveré a comprar." — María G.</blockquote>
                <blockquote class="border-l-4 border-emerald-200 pl-4 text-gray-700">"Atención al cliente muy amable y rápida solución a mi consulta." — José R.</blockquote>
            </div>
        </section>

        <!-- Newsletter / Footer pequeño -->
        <section class="bg-gray-50 p-6 rounded-lg">
            <footer class="text-sm text-gray-500 text-center">© {{ date('Y') }} Ximenabags — Hecho con cariño</footer>
        </section>
    </main>
</x-layouts.app>