<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Menu des onglets --}}
            <nav class="flex mb-6 space-x-4">
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-2 font-medium text-gray-700 rounded hover:bg-gray-100 @if(request()->routeIs('dashboard')) bg-gray-200 @endif">
                   Dashboard
                </a>

                @role('ADMIN')
                    <a href="{{ route('admin.users.index') }}"
                       class="px-3 py-2 font-medium text-gray-700 rounded hover:bg-gray-100 @if(request()->routeIs('admin.users.*')) bg-gray-200 @endif">
                       Utilisateurs
                    </a>
                @endrole
            </nav>

            {{-- Contenu principal --}}
            <div class="p-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @if(request()->routeIs('dashboard'))
                    <p class="text-gray-600">Bienvenue sur votre tableau de bord.</p>
                @elseif(request()->routeIs('admin.users.*'))
                    <livewire:admin.users />
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
