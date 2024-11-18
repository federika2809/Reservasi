<!DOCTYPE html>
<html lang="{{ str_replace('_', '_', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Meta For SEO --}}
        @yield('meta')

        {{-- Title --}}
        @yield('title')

        {{-- Style --}}
        @yield('style')
        
        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    </head>
    <body class="font-sans bg-gray-100 text-gray-900 antialiased">

        {{-- Content --}}
        @yield('content')

        {{-- Script --}}
        @yield('script')        

    </body>
</html>
