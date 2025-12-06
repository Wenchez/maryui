<x-layouts.app>
    <main class="max-w-3xl mx-auto px-6 py-16 space-y-12">
        <!-- Hero -->
        <section class="text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">Ximenabags</h1>
            <p class="text-lg  mb-5">Venta de bolsas, carteras , ropa y mas productos 100 % originales a un excelente
                precio</p>

            <div class="flex flex-col sm:flex-row justify-center gap-3 items-center">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                        class="inline-block px-6 py-3 border border-emerald-600 text-emerald-600 rounded-md font-medium hover:bg-emerald-50">Ingresar</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="inline-block px-6 py-3 border border-emerald-600 text-emerald-600 rounded-md font-medium hover:bg-emerald-50">Registrarse</a>
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

        <x-carousel :slides="$slides" class="h-100!" />

        <!-- Contactanos -->
        <section class="rounded-lg p-6 border-2 ">
            <h2 class="text-2xl font-semibold mb-6 text-center">Contáctanos</h2>

            <div class="flex flex-col items-center gap-6">
                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center mb-3">
                        📞</div>
                    <h3 class="font-medium">Número Telefónico</h3>
                    <p class="text-sm">+52 613 121 0095</p>
                </div>

                <div class="flex flex-col items-center">
                    <div
                        class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center mb-3">
                        📍</div>
                    <h3 class="font-medium">Dirección</h3>
                    <p class="text-sm">16 de Septiembre y Javier Fracc. Olimpico CD Contitucion B.C.S.</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center mb-3">
                        <!-- Logo de Facebook en SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-6 h-6 fill-blue-600">
                            <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06
                     52.24-50.06H295V6.26S273.71 0 252.36 0c-73.22 0-121.08
                     44.38-121.08 124.72v70.62H64v92.66h67.28V512h100.2V288z" />
                        </svg>
                    </div>

                    <h3 class="font-medium">Página de Facebook</h3>
                    <a href="https://www.facebook.com/share/17ib3HFfpD/" target="_blank" rel="noopener noreferrer"
                        class="btn btn-primary mt-3 inline-block px-4 py-2 rounded-md font-medium hover:opacity-95">
                        Visitar Facebook
                    </a>
                </div>
            </div>
        </section>

        <!-- Colecciones destacadas -->
        <section>
            <h2 class="text-2xl font-semibold mb-6 text-center">Colecciones</h2>

            <!-- Colección Primavera -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3 text-center">Colecciones Femeninas</h3>
                <p class="text-sm text-center mb-4">Colores vibrantes y diseños frescos para la temporada.</p>
                @php
                    $slidesPrimavera = [
                        ['image' => '/storage/products/PROD_001-Bolsa-Guess-Bolsa_Cafe.jpg'],
                        ['image' => '/storage/products/PROD_003-Crossbody-Guess-Crossbody_Guess.jpg'],
                        ['image' => '/storage/products/PROD_005-Crossbody-Karl_Lagerfeld-Crossbody_Karl.jpg'],
                        ['image' => '/storage/products/PROD_011-Sudadera-Calvin_Klein-Sudadera_blanca.jpg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesPrimavera" class="h-100!" />
            </div>

            <!-- Colección Bolsos -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-3 text-center ">Coleccion de Bolsos</h3>
                <p class="text-sm text-center  mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/storage/products/PROD_008-Mochila-Guess-Mochila_Negra.jpg'],
                        ['image' => '/storage/products/PROD_002-Bolsa-Guess-Bolsa_grande_Cafe.jpg'],
                        ['image' => '/storage/products/PROD_001-Bolsa-Guess-Bolsa_Cafe.jpg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" class="h-100!" />
            </div>

            <!-- Colección Accesorios -->
            <div class="mb-8">
                <h3 class="text-xl text-center  font-semibold mb-3">Coleccion de Accesorios</h3>
                <p class="text-sm text-center  mb-4">Modelos atemporales que nunca fallan.</p>
                @php
                    $slidesClasicos = [
                        ['image' => '/storage/products/PROD_009-Set-Steve_Madden-Set_bolso,_monedero_y_llavero.jpg'],
                        ['image' => '/storage/products/PROD_016-Cartera-Tommy_Hilfiger-Monedero_Tommy.jpg'],
                        ['image' => '/storage/products/PROD_017-Set-Steve_Madden-Set_Gorro_Bufanda.jpg'],
                    ];
                @endphp
                <x-carousel :slides="$slidesClasicos" class="h-100!" />
            </div>

        </section>


        <!-- Testimonios -->
        <section>
            <h2 class="text-2xl font-semibold mb-4">Lo que dicen nuestros clientes</h2>
            <div class="space-y-3">
                <blockquote class="border-l-4 pl-4 ">"La calidad es fantástica. Volveré a comprar." —
                    María G.</blockquote>
                <blockquote class="border-l-4 pl-4 ">"Atención al cliente muy amable y rápida" — José
                    R.</blockquote>
            </div>
        </section>
    </main>
</x-layouts.app>
