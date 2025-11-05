<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:styles />
    <livewire:scripts />
</head>

<body class="font-sans antialiased bg-base-100 min-h-screen">
    <x-navbar />

    <x-main with-nav class="flex-1 flex">
        <x-slot:sidebar drawer="main-drawer" class="bg-base-200 w-64 lg:hidden">
            <x-sidebar />
        </x-slot:sidebar>

        <x-slot:content>
            <div class="flex-1 flex items-center justify-center p-4 sm:p-6 md:p-8">
                {{ $slot }}
            </div>
        </x-slot:content>
    </x-main>
    
    <x-toast />
    <x-theme-toggle class="hidden" />
</body>

</html>
