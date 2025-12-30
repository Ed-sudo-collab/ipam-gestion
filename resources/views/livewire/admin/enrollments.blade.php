<div class="p-6 space-y-6">

    {{-- Alertes --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- En-tête et filtres --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-xl font-semibold">Liste des inscriptions</h2>
        <button
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded"
            wire:click="toggleModal">
            + Nouvelle inscription
        </button>
    </div>

{{-- Filtres --}}
<div class="bg-white p-4 rounded-lg shadow-md flex flex-col md:flex-row gap-4 flex-wrap">

    {{-- Recherche textuelle --}}
    <div class="flex flex-col flex-1 min-w-[200px]">
        <label class="mb-1 font-medium text-gray-700">Recherche</label>
        <input
            type="text"
            placeholder="Nom, prénom, matricule..."
            class="border rounded px-3 py-2 w-full"
            wire:model.live="filter_search"
        />
    </div>

    {{-- Statut inscription --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Statut inscription</label>
        <select class="border rounded px-3 py-2 w-full" wire:model.live="filter_statut">
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
        <select class="border rounded px-3 py-2 w-full" wire:model.live="filter_academic_year">
            <option value="">-- Toutes --</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->libelle }}</option>
            @endforeach
        </select>
    </div>

    {{-- Niveau --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Niveau</label>
        <select class="border rounded px-3 py-2 w-full" wire:model.live="filter_level">
            <option value="">-- Tous --</option>
            @foreach($levels as $level)
                <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Programme (Filière) --}}
    <div class="flex flex-col min-w-[180px]">
        <label class="mb-1 font-medium text-gray-700">Filière</label>
        <select class="border rounded px-3 py-2 w-full" wire:model.live="filter_program">
            <option value="">-- Toutes --</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}">{{ $program->name }}</option>
            @endforeach
        </select>
    </div>

</div>


    {{-- Tableau des inscriptions --}}
    <div class="bg-white p-6 rounded-lg shadow-md mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
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
                                        'Préinscrit' => 'bg-yellow-100 text-yellow-800',
                                        'Inscrit' => 'bg-green-100 text-green-800',
                                        'En attente de validation' => 'bg-orange-100 text-orange-800',
                                        'A jour' => 'bg-blue-100 text-blue-800',
                                        'En retard de payement' => 'bg-red-100 text-red-800',
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
                        <td class="px-4 py-2 space-x-2">
                            <button
                                x-data
                                @click.prevent="
                                    if (confirm('Voulez-vous vraiment annuler cette inscription ?')) {
                                        $wire.cancelEnrollment({{ $enroll->id }});
                                    }
                                "
                                class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                            >
                                Annuler
                            </button>
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
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-data="{ open: @entangle('showModal') }"
        x-show="open"
        x-transition
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">

            {{-- Close button --}}
            <button
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
                @click="open = false"
            >&times;</button>

            <h2 class="text-lg font-semibold mb-4">Nouvelle inscription</h2>

            <form wire:submit.prevent="submit" class="space-y-4">
                {{-- Étudiant --}}
                <div>
                    <label class="block font-medium mb-1">Étudiant</label>
                    <select wire:model="student_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir un étudiant --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->nom }} {{ $student->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Année académique --}}
                <div>
                    <label class="block font-medium mb-1">Année académique</label>
                    <select wire:model="academic_year_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir l'année --</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->libelle }}</option>
                        @endforeach
                    </select>
                    @error('academic_year_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Filière --}}
                <div>
                    <label class="block font-medium mb-1">Filière (Programme)</label>
                    <select wire:model="program_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir une filière --</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                    @error('program_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Niveau --}}
                <div>
                    <label class="block font-medium mb-1">Niveau</label>
                    <select wire:model="level_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir un niveau --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Mode d'étude --}}
                <div>
                    <label class="block font-medium mb-1">Mode d'étude</label>
                    <select wire:model="mode_etude" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir --</option>
                        <option value="presentiel">Présentiel</option>
                        <option value="en_ligne">En ligne</option>
                    </select>
                    @error('mode_etude') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Bouton --}}
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">
                    Enregistrer l'inscription
                </button>

            </form>
        </div>
    </div>

</div>
