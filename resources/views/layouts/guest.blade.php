<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DNT Travel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Nunito', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-secondary-900 antialiased bg-secondary-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/" class="flex items-center space-x-3 mb-6">
                    <i class="fas fa-fire text-warning-500 text-4xl"></i>
                    <span class="text-4xl font-extrabold text-secondary-900 tracking-tight">phoenix</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-lg rounded-2xl border border-secondary-100">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-secondary-800">Sign In</h2>
                    <p class="text-sm text-secondary-500 mt-2">Get access to your account</p>
                </div>
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-secondary-400">
                &copy; {{ date('Y') }} Dianta Andalan Haramain. All rights reserved.
            </div>
        </div>
        
        <!-- FontAwesome (if needed for guest layout icons) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </body>
</html>
