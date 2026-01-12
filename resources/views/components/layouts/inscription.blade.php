<x-app-layout>
    <!-- Menu horizontal Admin -->
    <div class="sticky top-16 z-50 mb-6 border-b border-gray-200 bg-white">
        <nav class="flex space-x-4" aria-label="Tabs">
            <!-- Gestion des étudiants -->
            <a href="{{ route('admin.enrollments.index') }}"
                class="px-3 py-2 text-sm font-medium border-b-2
                        {{ request()->routeIs('admin.enrollments.*')
                            ? 'border-indigo-500 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ __('Gestion des Inscriptions') }}
            </a>
        </nav>
    </div>

    <!-- Contenu spécifique -->
    <div class="p-6 bg-white rounded-lg shadow">
        {{ $slot }}
    </div>
</x-app-layout>
