<x-app-layout>
    <!-- Menu horizontal Admin -->
    <div class="sticky top-16 z-50 mb-6 border-b border-gray-200 bg-white">
        <nav class="sticky top-16 z-50  flex space-x-4" aria-label="Tabs">
            <!-- Gestion des programmes -->
            <a href="{{ route('admin.programs.index') }}"
               class="px-3 py-2 text-sm font-medium border-b-2
                      {{ request()->routeIs('admin.programs.*')
                          ? 'border-indigo-500 text-indigo-600'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ __('Gestion des programmes') }}
            </a>

            <!-- Gestion des niveaux -->
            <a href="{{ route('admin.levels.index') }}"
               class="px-3 py-2 text-sm font-medium border-b-2
                      {{ request()->routeIs('admin.levels.*')
                          ? 'border-indigo-500 text-indigo-600'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ __('Gestion des niveaux') }}
            </a>

            <!-- Gestion des années academiques -->
            <a href="{{ route('admin.academicYears.index') }}"
               class="px-3 py-2 text-sm font-medium border-b-2
                      {{ request()->routeIs('admin.academicYears.*')
                          ? 'border-indigo-500 text-indigo-600'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ __('Gestion des années académiques') }}
            </a>

        </nav>
    </div>

    <!-- Contenu spécifique -->
    <div class="p-6 bg-white rounded-lg shadow">
        {{ $slot }}
    </div>
</x-app-layout>





