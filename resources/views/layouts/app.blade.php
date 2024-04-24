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
        <div class="md:flex md:flex-row bg-white">
    
            <!-- Navigation Sidebar -->
            <aside class="w-fit h-fit bg-red-300" aria-label="Sidebar">
                @include('layouts.navigation')
            </aside>
    
            <!-- Page Content -->
            <div class="flex-1 mx-10 my-[3.75rem]">
                <!-- Main Content -->
                <main class="flex-1 w-fit bg-white">
                    {{ $slot }}
                </main>
            </div>
    
        </div>
    </body>
</html>
