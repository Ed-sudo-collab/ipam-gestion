<x-app-layout>
    <!-- Menu horizontal Admin -->
    <div class="sticky z-50 mb-0 bg-white border-b border-gray-200 top-16">
        <nav class="sticky z-50 flex space-x-4 top-16" aria-label="Tabs">
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
    <div >
        {{ $slot }}
    </div>
</x-app-layout>





