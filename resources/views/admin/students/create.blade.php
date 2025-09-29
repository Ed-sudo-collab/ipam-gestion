<x-layouts.etuInscri>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-xl sm:rounded-lg">
                {{-- Si $studentId est fourni, Livewire mount() recevra la valeur --}}
                <livewire:admin.student-wizard :student-id="$studentId ?? null" />
            </div>
        </div>
    </div>
</x-layouts.etuInscri>
