<div class="p-6 space-y-6">

    {{-- Alertes --}}
    @if (session()->has('success'))
        <div class="px-4 py-2 text-green-800 bg-green-100 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="px-4 py-2 text-red-800 bg-red-100 rounded shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- En-tête et filtres --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Liste des inscriptions</h2>
        <button
            class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700"
            wire:click="toggleModal">
            + Nouvelle inscription
        </button>
    </div>

        {{-- Export liste des étudiants --}}
   <p>
        <a href="{{ route('admin.reports.students') }}"
       target="_blank"
       class="px-4 py-2 mr-2 text-white bg-blue-600 rounded hover:bg-blue-700">
        Export Liste Étudiants (PDF)
    </a>
   </p>


{{-- Filtres --}}
<div class="flex flex-col flex-wrap gap-4 p-4 bg-white rounded-lg shadow-md md:flex-row">

    {{-- Recherche textuelle --}}
    <div class="flex flex-col flex-1 min-w-[200px]">
        <label class="mb-1 font-medium text-gray-700">Recherche</label>
        <input
            type="text"
            placeholder="Nom, prénom, matricule..."
            class="w-full px-3 py-2 border rounded"
            wire:model.live="filter_search"
        />
    </div>

    {{-- Statut inscription --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Statut inscription</label>
        <select class="w-full px-3 py-2 border rounded" wire:model.live="filter_statut">
            <option value="">-- Tous --</option>
            <option value="en_attente">En attente</option>
            <option value="validee">Validée</option>
            <option value="en_cours_paiement">En cours de paiement</option>
            <option value="terminee">Terminée</option>
            <option value="annulee">Annulée</option>
        </select>
    </div>

    {{-- Année académique --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Année académique</label>
        <select class="w-full px-3 py-2 border rounded" wire:model.live="filter_academic_year">
            <option value="">-- Toutes --</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->libelle }}</option>
            @endforeach
        </select>
    </div>

    {{-- Niveau --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Niveau</label>
        <select class="w-full px-3 py-2 border rounded" wire:model.live="filter_level">
            <option value="">-- Tous --</option>
            @foreach($levels as $level)
                <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Programme (Filière) --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Filière</label>
        <select class="w-full px-3 py-2 border rounded" wire:model.live="filter_program">
            <option value="">-- Toutes --</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}">{{ $program->name }}</option>
            @endforeach
        </select>
    </div>

</div>


    {{-- Tableau des inscriptions --}}
    <div class="p-6 mt-4 overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Étudiant</th>
                    <th class="px-4 py-2 text-left">Statut étudiant</th>
                    <th class="px-4 py-2 text-left">Année</th>
                    <th class="px-4 py-2 text-left">Filière</th>
                    <th class="px-4 py-2 text-left">Niveau</th>
                    <th class="px-4 py-2 text-left">Mode d'étude</th>
                    <th class="px-4 py-2 text-left">Statut inscription</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($enrollments as $enroll)
                    <tr>
                        <td class="px-4 py-2">{{ $enroll->student->nom }} {{ $enroll->student->prenom }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @php
                                    $colors = [
                                        'Préinscrit'             => 'bg-yellow-100 text-yellow-800',
                                        'En attente de validation'=> 'bg-orange-100 text-orange-800',
                                        'Inscrit'                => 'bg-green-100 text-green-800',
                                        'A jour'                 => 'bg-blue-100 text-blue-800',
                                        'En retard de paiement'   => 'bg-red-100 text-red-800',
                                        'En cours de paiement'   => 'bg-indigo-100 text-indigo-800',
                                    ];

                                    echo $colors[$enroll->student->statut->libelle ?? ''] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                            ">
                                {{ $enroll->student->statut->libelle ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $enroll->academicYear->libelle ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $enroll->program->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $enroll->level->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($enroll->mode_etude) }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @php
                                    $statusColors = [
                                        'en_cours_paiement' => 'bg-yellow-100 text-yellow-800',
                                        'en_attente' => 'bg-orange-100 text-orange-800',
                                        'validee' => 'bg-green-100 text-green-800',
                                        'terminee' => 'bg-blue-100 text-blue-800',
                                        'annulee' => 'bg-red-100 text-red-800',
                                    ];
                                    echo $statusColors[$enroll->statut] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                            ">
                                {{ ucfirst(str_replace('_', ' ', $enroll->statut)) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $enroll->date_inscription?->format('d/m/Y') }}</td>

                        <td class="px-4 py-2">
                            <div class="flex items-center gap-2">

                                {{-- ❌ Annuler --}}
                                <button
                                    x-data
                                    @click.prevent="
                                        if (confirm('Voulez-vous vraiment annuler cette inscription ?')) {
                                            $wire.cancelEnrollment({{ $enroll->id }});
                                        }
                                    "
                                    title="Annuler l'inscription"
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-white bg-red-600 rounded hover:bg-red-700 transition"
                                >
                                    ❌
                                </button>

                                {{-- 📜 Attestation --}}
                                @if($enroll->statut === 'validee')
                                    <a
                                        href="{{ route('admin.enrollments.attestation', ['enrollmentId' => $enroll->id]) }}"
                                        title="Voir l’attestation d'inscription"
                                        class="inline-flex items-center justify-center text-white transition bg-blue-600 rounded w-9 h-9 hover:bg-blue-700"
                                    >
                                        📜
                                    </a>
                                @endif


                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-2 text-center text-gray-500">
                            Aucune inscription trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Nouvelle inscription --}}
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-data="{ open: @entangle('showModal') }"
        x-show="open"
        x-transition
    >
        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">

            {{-- Close button --}}
            <button
                class="absolute text-gray-500 top-3 right-3 hover:text-gray-700"
                @click="open = false"
            >&times;</button>

            <h2 class="mb-4 text-lg font-semibold">Nouvelle inscription</h2>

            <form wire:submit.prevent="submit" class="space-y-4">
                {{-- Étudiant --}}
                {{-- Étudiant (recherche dynamique) --}}
                <div class="relative">
                    <label class="block mb-1 font-medium">Étudiant</label>

                    <input
                        type="text"
                        wire:model.debounce.300ms="student_search"
                        placeholder="Nom, prénom ou matricule..."
                        class="w-full px-3 py-2 border rounded"
                    >

                    {{-- Liste résultats --}}
                    @if(!empty($filteredStudents))
                        <ul class="absolute z-50 w-full mt-1 bg-white border rounded shadow max-h-48 overflow-y-auto">
                            @foreach($filteredStudents as $student)
                                <li
                                    wire:click="selectStudent({{ $student->id }})"
                                    class="px-3 py-2 cursor-pointer hover:bg-indigo-100"
                                >
                                    {{ $student->nom }} {{ $student->prenom }}
                                    <span class="text-sm text-gray-500">
                                        ({{ $student->matricule }})
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Étudiant sélectionné --}}
                    @if($student_id)
                        <p class="mt-1 text-sm text-green-600">
                            ✔ Étudiant sélectionné
                        </p>
                    @endif

                    @error('student_id')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Année académique --}}
                <div>
                    <label class="block mb-1 font-medium">Année académique</label>
                    <select wire:model="academic_year_id" class="w-full px-3 py-2 border rounded">
                        <option value="">-- Choisir l'année --</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->libelle }}</option>
                        @endforeach
                    </select>
                    @error('academic_year_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Filière --}}
                <div>
                    <label class="block mb-1 font-medium">Filière (Programme)</label>
                    <select wire:model="program_id" class="w-full px-3 py-2 border rounded">
                        <option value="">-- Choisir une filière --</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                    @error('program_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Niveau --}}
                <div>
                    <label class="block mb-1 font-medium">Niveau</label>
                    <select wire:model="level_id" class="w-full px-3 py-2 border rounded">
                        <option value="">-- Choisir un niveau --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Mode d'étude --}}
                <div>
                    <label class="block mb-1 font-medium">Mode d'étude</label>
                    <select wire:model="mode_etude" class="w-full px-3 py-2 border rounded">
                        <option value="">-- Choisir --</option>
                        <option value="presentiel">Présentiel</option>
                        <option value="en_ligne">En ligne</option>
                    </select>
                    @error('mode_etude') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                {{-- Bouton --}}
                <button type="submit" class="w-full px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    Enregistrer l'inscription
                </button>

            </form>
        </div>
    </div>

</div>
