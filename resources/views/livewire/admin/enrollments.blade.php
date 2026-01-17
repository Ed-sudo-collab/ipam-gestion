<div class="min-h-screen p-6 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <!-- Alertes -->
    @if (session()->has('success'))
        <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="flex items-center gap-3 p-4 mb-6 text-red-100 bg-red-900 border border-red-700 rounded-lg">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- En-tête -->
    <div class="flex flex-col gap-4 mb-8 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="mb-2 text-4xl font-bold text-white">Liste des inscriptions</h1>
            <p class="text-gray-400">Gérez les inscriptions des étudiants</p>
        </div>

        <button wire:click="toggleModal"
            class="flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Nouvelle inscription
        </button>
    </div>

    <!-- Export -->
    <div class="mb-6">
        <a href="{{ route('admin.reports.students') }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4z"></path>
            </svg>
            Export PDF
        </a>
    </div>

    <!-- Filtres -->
    <div class="p-6 mb-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 016 17v-3.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
            </svg>
            Filtres
        </h3>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
            <!-- Recherche -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Recherche</label>
                <div class="relative">
                    <svg class="absolute w-5 h-5 text-gray-500 left-3 top-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    <input type="text"
                        placeholder="Nom, prénom, matricule..."
                        wire:model.live="filter_search"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                </div>
            </div>

            <!-- Statut inscription -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Statut inscription</label>
                <select wire:model.live="filter_statut"
                    class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    <option value="">-- Tous --</option>
                    <option value="en_attente">En attente</option>
                    <option value="validee">Validée</option>
                    <option value="en_cours_paiement">En cours de paiement</option>
                    <option value="terminee">Terminée</option>
                    <option value="annulee">Annulée</option>
                </select>
            </div>

            <!-- Année académique -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Année académique</label>
                <select wire:model.live="filter_academic_year"
                    class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    <option value="">-- Toutes --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Niveau -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Niveau</label>
                <select wire:model.live="filter_level"
                    class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    <option value="">-- Tous --</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filière -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-300">Filière</label>
                <select wire:model.live="filter_program"
                    class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    <option value="">-- Toutes --</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Tableau des inscriptions -->
    <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 border-b border-gray-700">
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Étudiant</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Statut étudiant</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Année</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Filière</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Niveau</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Mode d'étude</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Statut inscription</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Date</th>
                        <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($enrollments as $enroll)
                        <tr class="transition duration-150 hover:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-200">{{ $enroll->student->nom }} {{ $enroll->student->prenom }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'Préinscrit'             => 'bg-yellow-900 text-yellow-200',
                                        'En attente de validation'=> 'bg-orange-900 text-orange-200',
                                        'Inscrit'                => 'bg-green-900 text-green-200',
                                        'A jour'                 => 'bg-blue-900 text-blue-200',
                                        'En retard de paiement'   => 'bg-red-900 text-red-200',
                                        'En cours de paiement'   => 'bg-indigo-900 text-indigo-200',
                                    ];

                                    $color = $colors[$enroll->student->statut->libelle ?? ''] ?? 'bg-gray-700 text-gray-300';
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                    ● {{ $enroll->student->statut->libelle ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ $enroll->academicYear->libelle ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $enroll->program->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $enroll->level->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium text-gray-300 bg-gray-800 rounded-full">
                                    {{ ucfirst($enroll->mode_etude) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'en_cours_paiement' => 'bg-yellow-900 text-yellow-200',
                                        'en_attente' => 'bg-orange-900 text-orange-200',
                                        'validee' => 'bg-green-900 text-green-200',
                                        'terminee' => 'bg-blue-900 text-blue-200',
                                        'annulee' => 'bg-red-900 text-red-200',
                                    ];
                                    $statusColor = $statusColors[$enroll->statut] ?? 'bg-gray-700 text-gray-300';
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                    ● {{ ucfirst(str_replace('_', ' ', $enroll->statut)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $enroll->date_inscription?->format('d/m/Y') }}</td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <!-- Annuler -->
                                    <button
                                        x-data
                                        @click.prevent="
                                            if (confirm('Êtes-vous sûr de vouloir annuler cette inscription ?')) {
                                                $wire.cancelEnrollment({{ $enroll->id }});
                                            }
                                        "
                                        title="Annuler l'inscription"
                                        class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">
                                        Annuler
                                    </button>

                                    <!-- Attestation -->
                                    @if($enroll->statut === 'validee')
                                        <a href="{{ route('admin.enrollments.attestation', ['enrollmentId' => $enroll->id]) }}"
                                           title="Voir l'attestation d'inscription"
                                           class="px-3 py-1.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-medium rounded transition duration-150 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V6a1 1 0 100-2 2 2 0 01-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2h2a1 1 0 100-2H6a1 1 0 01-1-1V5z" clip-rule="evenodd"></path>
                                            </svg>
                                            Attestation
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                Aucune inscription trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- Modal Nouvelle inscription -->
    <div x-data="{ open: @entangle('showModal') }"
         x-show="open"
         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-70">
        <div class="w-full max-w-lg bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <h2 class="text-2xl font-bold text-white">Nouvelle inscription</h2>
                <button @click="open = false" class="text-gray-400 hover:text-gray-300">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form wire:submit.prevent="submit" class="p-6 space-y-5">
                <!-- Étudiant (recherche dynamique) -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Étudiant</label>
                    <input type="text"
                        wire:model.debounce.300ms="student_search"
                        placeholder="Nom, prénom ou matricule..."
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">

                    <!-- Liste résultats -->
                    @if(!empty($filteredStudents))
                        <ul class="absolute z-50 w-full mt-1 overflow-y-auto bg-gray-800 border border-gray-700 rounded-lg shadow max-h-48">
                            @foreach($filteredStudents as $student)
                                <li wire:click="selectStudent({{ $student->id }})"
                                    class="px-4 py-2.5 cursor-pointer hover:bg-gray-700 text-gray-300 border-b border-gray-700 last:border-b-0 transition">
                                    <p class="font-medium text-white">{{ $student->nom }} {{ $student->prenom }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->matricule }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Étudiant sélectionné -->
                    @if($student_id)
                        <p class="flex items-center gap-2 mt-2 text-sm text-green-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Étudiant sélectionné
                        </p>
                    @endif

                    @error('student_id')
                        <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Année académique -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Année académique</label>
                    <select wire:model="academic_year_id"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="">-- Choisir l'année --</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->libelle }}</option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Filière -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Filière (Programme)</label>
                    <select wire:model="program_id"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="">-- Choisir une filière --</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                    @error('program_id')
                        <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Niveau -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Niveau</label>
                    <select wire:model="level_id"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="">-- Choisir un niveau --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mode d'étude -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Mode d'étude</label>
                    <select wire:model="mode_etude"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="">-- Choisir --</option>
                        <option value="presentiel">Présentiel</option>
                        <option value="en_ligne">En ligne</option>
                    </select>
                    @error('mode_etude')
                        <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3 pt-4">
                    <button type="button" @click="open = false"
                        class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition duration-150">
                        Enregistrer l'inscription
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
