<div>
    <div class="flex mb-4 border-b">
        <button wire:click="$set('activeTab', 'general')"
                class="px-4 py-2 font-medium rounded-t-lg {{ $activeTab === 'general' ? 'bg-white border-t border-l border-r' : 'bg-gray-100' }}">
            Informations générales
        </button>
        <button wire:click="$set('activeTab', 'academic')"
                class="px-4 py-2 font-medium rounded-t-lg {{ $activeTab === 'academic' ? 'bg-white border-t border-l border-r' : 'bg-gray-100' }}">
            Académiques
        </button>
        <button wire:click="$set('activeTab', 'professional')"
                class="px-4 py-2 font-medium rounded-t-lg {{ $activeTab === 'professional' ? 'bg-white border-t border-l border-r' : 'bg-gray-100' }}">
            Professionnelles
        </button>
        <button wire:click="$set('activeTab', 'documents')"
                class="px-4 py-2 font-medium rounded-t-lg {{ $activeTab === 'documents' ? 'bg-white border-t border-l border-r' : 'bg-gray-100' }}">
            Documents
        </button>
    </div>

    <div class="p-4 bg-white rounded-b-lg shadow">
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
