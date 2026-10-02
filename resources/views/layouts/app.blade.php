<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGEZOO') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2">
                    <div>{{ $header }}</div>
                    @unless (request()->routeIs('dashboard'))
                        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:underline whitespace-nowrap">
                            ← Volver al dashboard
                        </a>
                    @endunless
                </div>
            </header>
        @endisset

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-800">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>