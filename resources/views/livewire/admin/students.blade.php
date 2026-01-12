<div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">

    <!-- En-tête et filtres -->
    <div class="mb-8">
        <h1 class="mb-2 text-4xl font-bold text-white">Liste des étudiants</h1>
        <p class="text-gray-400">Gérez et administrez les étudiants de votre plateforme</p>
    </div>

    <!-- Export et Ajouter -->
    <div class="flex flex-col gap-3 mb-8 md:flex-row md:items-center md:gap-4">
        <a href="{{ route('admin.reports.students') }}"
           target="_blank"
           class="flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4z"></path>
                <path fill-rule="evenodd" d="M8 10a1 1 0 100 2h2a1 1 0 100-2H8z" clip-rule="evenodd"></path>
            </svg>
            Export PDF
        </a>

        <a href="{{ route('admin.students.create') }}"
           class="flex items-center gap-2 px-6 py-3 ml-auto font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Ajouter un étudiant
        </a>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
        <!-- 🔍 Recherche -->
        <div class="md:col-span-2">
            <label class="block mb-2 text-sm font-semibold text-gray-300">Recherche</label>
            <div class="relative">
                <svg class="absolute w-5 h-5 text-gray-500 left-3 top-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Nom, prénom ou matricule"
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150"
                />
            </div>
        </div>

        <!-- 👤 Statut -->
        <div>
            <label class="block mb-2 text-sm font-semibold text-gray-300">Statut étudiant</label>
            <select wire:model.live="statut_id" class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                <option value="">-- Tous les statuts --</option>
                @foreach ($statuts as $statut)
                    <option value="{{ $statut->id }}">
                        {{ $statut->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Tableau étudiants -->
    <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 border-b border-gray-700">
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Matricule</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Nom</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Prénom</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Email</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Téléphone</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Statut</th>
                        <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($students as $student)
                        <tr class="transition duration-150 hover:bg-gray-800">
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium text-gray-300 bg-gray-800 rounded">
                                    {{ $student->matricule }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-200">{{ $student->nom }}</td>
                            <td class="px-6 py-4 text-gray-200">{{ $student->prenom }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $student->email }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $student->telephone }}</td>

                            <!-- Colonne statut avec badge coloré -->
                            <td class="px-6 py-4">
                                @if($student->statut)
                                    @php
                                        $colors = [
                                            'Préinscrit'             => 'bg-yellow-900 text-yellow-200',
                                            'En attente de validation'=> 'bg-orange-900 text-orange-200',
                                            'Inscrit'                => 'bg-green-900 text-green-200',
                                            'A jour'                 => 'bg-blue-900 text-blue-200',
                                            'En retard de paiement'   => 'bg-red-900 text-red-200',
                                            'En cours de paiement'   => 'bg-indigo-900 text-indigo-200',
                                        ];

                                        $color = $colors[$student->statut->libelle] ?? 'bg-gray-700 text-gray-300';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                        ● {{ $student->statut->libelle }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium text-gray-300 bg-gray-700 rounded-full">N/A</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                       class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition duration-150">
                                        Détails
                                    </a>

                                    <a href="{{ route('admin.students.edit', $student->id) }}"
                                       class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded transition duration-150">
                                        Modifier
                                    </a>

                                    <button wire:click="delete({{ $student->id }})"
                                            onclick="return confirm('Supprimer cet étudiant ?')"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Aucun étudiant trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $students->links() }}
    </div>
</div>
