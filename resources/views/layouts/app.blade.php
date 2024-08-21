<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>{{ config('settings.site_name', 'Laravel') }}</title>



    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    @yield('header')

    <!-- Scripts -->

    <wireui:scripts />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    @stack('head')

</head>

<body class="font-sans text-gray-900 antialiased dark:bg-gray-900">

@include('_particles.navbar')

<main>

    @yield('content',$slot ??'')

</main>

@include('_particles.footer')

<x-notifications position="bottom-right" />

<x-dialog z-index="z-50" blur="md" align="center" />

@livewireScripts

@stack('scripts')

<script>

    // On page load or when changing themes, best to add inline in `head` to avoid FOUC

    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {

        document.documentElement.classList.add('dark');

    } else {

        document.documentElement.classList.remove('dark')

    }

</script>

</body>

</html>

