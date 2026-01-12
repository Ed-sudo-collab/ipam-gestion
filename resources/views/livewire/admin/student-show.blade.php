<div>
    <!-- Onglets -->
    <div class="mb-6">
        <div class="flex gap-2 border-b border-gray-700">
            <button wire:click="$set('activeTab', 'general')"
                class="px-6 py-3 font-semibold text-sm transition duration-200 border-b-2 {{ $activeTab === 'general' ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5m-15-4h4m-4 4h10m-10 4h10m-10 4h4" stroke="currentColor" stroke-width="1.5" fill="none"></path>
                </svg>
                Informations générales
            </button>
            <button wire:click="$set('activeTab', 'academic')"
                class="px-6 py-3 font-semibold text-sm transition duration-200 border-b-2 {{ $activeTab === 'academic' ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                </svg>
                Académiques
            </button>
            <button wire:click="$set('activeTab', 'professional')"
                class="px-6 py-3 font-semibold text-sm transition duration-200 border-b-2 {{ $activeTab === 'professional' ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
                Professionnelles
            </button>
            <button wire:click="$set('activeTab', 'documents')"
                class="px-6 py-3 font-semibold text-sm transition duration-200 border-b-2 {{ $activeTab === 'documents' ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a2 2 0 012-2h4a1 1 0 01.894.553l1.788 3.577a1 1 0 11-1.788.894L13.027 4H10v5a2 2 0 11-4 0V4zm3 1a1 1 0 000 2h.01a1 1 0 100-2H11zm3 4.129a2 2 0 00-2 2V9a2 2 0 10-4 0v.129a2 2 0 00-2 2v5a2 2 0 002 2h4a2 2 0 002-2v-5a2 2 0 00-2-2zm1 2a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                </svg>
                Documents
            </button>
        </div>
    </div>

    <!-- Contenu des onglets -->
    <div class="p-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        @if($activeTab === 'general')
            @livewire('admin.student-general', ['student' => $student])
        @elseif($activeTab === 'academic')
            @livewire('admin.student-academic', ['student' => $student])
        @elseif($activeTab === 'professional')
            @livewire('admin.student-professional', ['student' => $student])
        @elseif($activeTab === 'documents')
            @livewire('admin.student-documents', ['student' => $student])
        @endif
    </div>
</div>
