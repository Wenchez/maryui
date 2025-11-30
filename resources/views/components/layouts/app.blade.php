<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js">
    </script>
</head>

<body class="font-sans antialiased bg-base-100 min-h-screen">
    <x-navbar />

    <x-main with-nav class="flex-1 flex">
        <x-slot:sidebar drawer="main-drawer" class="bg-base-200 w-64 lg:hidden">
            <x-sidebar />
        </x-slot:sidebar>

        <x-slot:content>
            <div class="flex-1 flex items-center">
                {{ $slot }}
            </div>
        </x-slot:content>
    </x-main>

    <div {{ $attributes->merge(['class' => 'w-full bg-base-200 p-6 text-center text-sm']) }}>
        © {{ date('Y') }} Ximenabags — Hecho con cariño
    </div>

    <x-toast />
    <x-theme-toggle class="hidden" />

    @livewireScripts
</body>

</html>
