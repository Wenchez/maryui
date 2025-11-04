<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-base-100 min-h-screen">
    <x-navbar />

    <x-main with-nav full-width>
        <x-slot:sidebar drawer="main-drawer" class="bg-base-200 lg:hidden">
            <x-sidebar />
        </x-slot:sidebar>
        
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
    
    <x-toast />
    <x-theme-toggle class="hidden" />
</body>
</html>
