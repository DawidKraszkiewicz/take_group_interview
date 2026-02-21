<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased dark:bg-zinc-900 dark:text-zinc-100">
    <div class="min-h-screen container mx-auto p-4">
        <header class="mb-8 flex flex-row justify-between items-center">
            <h1 class="text-3xl font-bold">TMDB Movies</h1>
        </header>

        <main>
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
