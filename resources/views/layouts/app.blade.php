<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskSystem') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased w-full">
        <div class="md:flex md:flex-row">
    
            <!-- Navigation Sidebar -->
            <aside class="w-fit h-fit sticky top-0" aria-label="Sidebar">
                @include('layouts.navigation')
            </aside>
    
            <!-- Page Content -->
            <div class="flex-1 mx-10 mt-[3.75rem]">
                <!-- Ícone de logout -->
                <div class="relative w-full text-white text-end">
                    @include('users.logout')
                </div>

                <!-- Main Content -->
                <main class="flex-1 w-full">
                    {{ $slot }}
                </main>
            </div>
    
        </div>
    </body>
</html>
