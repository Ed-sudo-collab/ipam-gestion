<x-app-layout>


    <!-- Menu horizontal Admin -->
    <div class="sticky z-50 mb-0 bg-white border-b border-gray-200 top-16">
        <nav class="flex space-x-4" aria-label="Tabs">
            <!-- Gestion des frais de scolarités -->
            <a href="{{ route('admin.payements.index') }}"
                class="px-3 py-2 text-sm font-medium border-b-2
                        {{ request()->routeIs('admin.payements.*')
                            ? 'border-indigo-500 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ __('Gestion des paiements') }}
            </a>







            <a href="{{ route('admin.finance.index') }}"
                class="px-3 py-2 text-sm font-medium border-b-2
                        {{ request()->routeIs('admin.finance.*')
                            ? 'border-indigo-500 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ __('Situation financière d\'un étudiant') }}
            </a>



            <a href="{{ route('admin.paymentHistoriq.index') }}"
                class="px-3 py-2 text-sm font-medium border-b-2
                        {{ request()->routeIs('admin.paymentHistoriq.*')
                            ? 'border-indigo-500 text-indigo-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ __('Historique des paiements') }}
            </a>

        </nav>
    </div>

    <!-- Contenu spécifique -->
    <div>
        {{ $slot }}

        <!-- Styles -->
        @livewireStyles

    </div>
</x-app-layout>





