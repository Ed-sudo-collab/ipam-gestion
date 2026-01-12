<x-app-layout>
    <!-- Menu horizontal Admin -->
    <div class="sticky top-16 z-50 mb-6 border-b border-gray-200 bg-white">
        <nav class="flex space-x-4" aria-label="Tabs">
            <!-- Gestion des étudiants -->
            <a href="{{ route('admin.students.index') }}"
               class="px-3 py-2 text-sm font-medium border-b-2
                      {{ request()->routeIs('admin.students.*')
                          ? 'border-indigo-500 text-indigo-600'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ __('Gestion des étudiants') }}
            </a>

            <!-- Gestion des Inscriptions -->






            <!-- Gestion des Statuts d'étudiants -->
            <a href="{{ route('admin.studentStatut.index') }}"
               class="px-3 py-2 text-sm font-medium border-b-2
                      {{ request()->routeIs('admin.studentStatut.*')
                          ? 'border-indigo-500 text-indigo-600'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ __('Gestion des statuts d\'étudiants') }}
            </a>



        </nav>
    </div>

    <!-- Contenu spécifique -->
    <div class="p-6 bg-white rounded-lg shadow">
        {{ $slot }}
    </div>
</x-app-layout>





