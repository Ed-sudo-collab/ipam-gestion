<div>
     {{-- En-tête et filtres --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Liste des étudiants</h2>

    </div>


        {{-- Export liste des étudiants --}}
    <a href="{{ route('admin.reports.students') }}"
       target="_blank"
       class="px-4 py-2 mr-2 text-white bg-blue-600 rounded hover:bg-blue-700">
        Export Liste Étudiants (PDF)
    </a>

    <br><br>
    {{-- Barre d'actions --}}
    <div class="flex flex-col gap-4 mb-4 md:flex-row">

        <!-- 🔍 Recherche -->
        <div class="flex flex-col flex-1 min-w-[200px]">
            <label class="mb-1 font-medium text-gray-700">Recherche</label>
            <input
                type="text"
                wire:model.live="search"
                placeholder="Nom, prénom ou matricule"
                class="w-full px-3 py-2 border rounded-lg"
            />
        </div>

        <!-- 👤 Statut -->
        <div class="flex flex-col min-w-[180px]">
            <label class="mb-1 font-medium text-gray-700">Statut étudiant</label>
            <select wire:model.live="statut_id" class="w-full px-3 py-2 border rounded-lg">
                <option value="">-- Tous les statuts --</option>
                @foreach ($statuts as $statut)
                    <option value="{{ $statut->id }}">
                        {{ $statut->libelle }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col min-w-[180px]">
            <a href="{{ route('admin.students.create') }}"
            class="px-4 py-2 text-center text-white bg-indigo-600 rounded hover:bg-indigo-700">
                + Ajouter un étudiant
            </a>
        </div>

    </div>



    {{-- Tableau étudiants --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Matricule</th>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Prénom</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Téléphone</th>
                    <th class="px-4 py-2">Statut</th> {{-- ✅ nouvelle colonne --}}
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $student->matricule }}</td>
                        <td class="px-4 py-2">{{ $student->nom }}</td>
                        <td class="px-4 py-2">{{ $student->prenom }}</td>
                        <td class="px-4 py-2">{{ $student->email }}</td>
                        <td class="px-4 py-2">{{ $student->telephone }}</td>

                        {{-- ✅ Colonne statut avec badge coloré --}}
                        <td class="px-4 py-2">
                            @if($student->statut)
                                @php
                                    $colors = [
                                        'Préinscrit'             => 'bg-yellow-100 text-yellow-800',
                                        'En attente de validation'=> 'bg-orange-100 text-orange-800',
                                        'Inscrit'                => 'bg-green-100 text-green-800',
                                        'A jour'                 => 'bg-blue-100 text-blue-800',
                                        'En retard de paiement'   => 'bg-red-100 text-red-800',
                                        'En cours de paiement'   => 'bg-indigo-100 text-indigo-800',
                                    ];

                                    $color = $colors[$student->statut->libelle] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $color }}">
                                    {{ $student->statut->libelle }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded">N/A</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-2 space-x-2">
                            {{-- Edition wizard --}}
                            <a href="{{ route('admin.students.edit', $student->id) }}"
                               class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Modifier
                            </a>

                            {{-- Lecture seule wizard --}}
                            <a href="{{ route('admin.students.show', $student->id) }}"
                               class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">
                                Détails
                            </a>

                            <button wire:click="delete({{ $student->id }})"
                                    onclick="return confirm('Supprimer cet étudiant ?')"
                                    class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">
                            Aucun étudiant trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
