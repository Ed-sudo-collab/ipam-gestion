<x-layouts.etuInscri>
   <div class="p-0">
            <div class="w-full px-0 mx-0">
                {{-- Si $studentId est fourni, Livewire mount() le recevra --}}
                @livewire('App\Livewire\Admin\StudentWizard', ['studentId' => $student->id])
            </div>
    </div>

</x-layouts.etuInscri>
