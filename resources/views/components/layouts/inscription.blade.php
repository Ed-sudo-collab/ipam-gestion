<x-app-layout>
    <!-- Menu horizontal Admin -->
    <div class="sticky z-50 mb-0 bg-white border-b border-gray-200 top-16">
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
    <div>
        {{ $slot }}
    </div>
</x-app-layout>
