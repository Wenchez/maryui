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
                ['image' => '/storage/products/PROD_013-Tenis-Guess-Tenis_Blancos.jpg'],
                ['image' => '/storage/products/PROD_008-Mochila-Guess-Mochila_Negra.jpg'],
                ['image' => '/storage/products/PROD_002-Bolsa-Guess-Bolsa_grande_Cafe.jpg'],
                ['image' => '/storage/products/PROD_009-Set-Steve_Madden-Set_bolso,_monedero_y_llavero.jpg'],
            ];
        @endphp

        <x-carousel :slides="$slides" class="h-100!"/>

        <!-- Características -->
        <section class="rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-center">Contactanos</h2>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">⭐</div>
                    <div>
                        <h3 class="font-medium">Numero Telefonico</h3>
                        <p class="text-sm">+52 613 121 0095</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">⭐</div>
                    <div>
                        <h3 class="font-medium">Direccion</h3>
                        <p class="text-sm text-gray-600">16 de Septiembre y Javier Fracc. Olimpico CD Contitucion B.C.S.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">⭐</div>
                    <div>
                        <h3 class="font-medium">Pagina de Facebook</h3>
                        <p class="text-sm text-gray-600">https://www.facebook.com/share/17ib3HFfpD/</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Colecciones destacadas -->
        <section>
            <h2 class="text-2xl font-semibold mb-6 text-center">Colecciones</h2>
            
            <!-- Colección Primavera -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Colecciones Femeninas</h3>
                <p class="text-sm text-gray-600 mb-4">Colores vibrantes y diseños frescos para la temporada.</p>
                @php
                    $slidesPrimavera = [
                        ['image' => '/storage/products/PROD_001-Bolsa-Guess-Bolsa_Cafe.jpg'],
                        ['image' => '/storage/products/PROD_003-Crossbody-Guess-Crossbody_Guess.jpg'],
                        ['image' => '/storage/products/PROD_005-Crossbody-Karl_Lagerfeld-Crossbody_Karl.jpg'],
                        ['image' => '/storage/products/PROD_011-Sudadera-Calvin_Klein-Sudadera_blanca.jpg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesPrimavera" class="h-100!"/>
            </div>

            <!-- Colección Bolsos -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Coleccion de Bolsos</h3>
                <p class="text-sm text-gray-600 mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/storage/products/PROD_016-Bolsa-Guess-Negra-Grande.jpeg'],
                        ['image' => '/storage/products/PROD_002-Bolsa-Guess-Bolsa_grande_Cafe.jpg'],
                        ['image' => '/storage/products/PROD_001-Bolsa-Guess-Bolsa_Cafe.jpg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" class="h-100!"/>
            </div>

            <!-- Colección Accesorios -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Coleccion de Accesorios</h3>
                <p class="text-sm text-gray-600 mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/photos/IMG_WELCOME/WhatsApp Image 2025-11-11 at 10.40.43 PM.jpeg'],
                        ['image' => '/photos/IMG_WELCOME/WhatsApp Image 2025-11-11 at 10.40.43 PM (4).jpeg'],
                        ['image' => '/photos/IMG_WELCOME/WhatsApp Image 2025-11-11 at 10.40.43 PM (1).jpeg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" class="h-100!"/>
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