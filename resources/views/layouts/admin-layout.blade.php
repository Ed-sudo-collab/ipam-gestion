{{-- resources/views/layouts/admin-layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mon Application') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">

    {{-- Topbar dynamique selon rôle --}}
    @php
        $role = Auth::user()->roles->pluck('name')->first(); // récupérer le premier rôle
    @endphp

    @switch($role)
        @case('ADMIN')
            @include('layouts.admin-topbar')
            @break

        @case('SECRETAIRE')
            @include('layouts.secretaire-topbar')
            @break

        @case('COMPTABLE')
            @include('layouts.comptable-topbar')
            @break

        @case('ETUDIANT')
            @include('layouts.etudiant-topbar')
            @break

        @default
            {{-- Topbar par défaut si aucun rôle --}}
            <div class="bg-red-500 text-white p-4 text-center font-bold">
                Rôle non défini
            </div>
    @endswitch

    {{-- Contenu principal --}}
    <main class="py-6 px-4 sm:px-6 lg:px-8 min-h-screen">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
