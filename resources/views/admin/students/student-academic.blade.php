<x-layouts.etuInscri>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-xl sm:rounded-lg">

                {{-- Composant parent StudentAcademic --}}
                @livewire('App\Livewire\Admin\StudentAcademic', ['studentId' => $student->id])
            </div>
        </div>
    </div>
</x-layouts.etuInscri>

