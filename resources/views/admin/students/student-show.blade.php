<x-layouts.etuInscri>
    <div class="p-0">
            <div class="w-full px-0 mx-0">
                {{-- Composant parent StudentShow --}}
                @livewire('App\Livewire\Admin\StudentShow', ['studentId' => $student->id])
            </div>
    </div>
</x-layouts.etuInscri>

