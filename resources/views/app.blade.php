<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Issue Tracker')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css') {{-- Tailwind is already included via Breeze --}}
</head>
<body class="bg-gray-100 text-gray-900">
<div class="min-h-screen flex flex-col">
    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-indigo-600">Issue Tracker</h1>
            <nav>
                <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-indigo-600">Projects</a>
            </nav>
        </div>
    </header>

    <main class="flex-1 container mx-auto px-6 py-8">
        @yield('content')
    </main>
</div>
</body>
</html>
