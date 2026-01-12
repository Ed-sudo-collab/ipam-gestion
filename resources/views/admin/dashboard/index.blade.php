<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="p-0">
        <div class="mx-0 w-full px-0">
            @livewire('admin.dashboard')
        </div>
    </div>
</x-app-layout>
