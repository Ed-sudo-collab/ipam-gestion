<div>
    {{-- Barre d'actions --}}
    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model="search" placeholder="Rechercher..."
               class="px-3 py-2 border rounded-lg" />
        <a href="{{ route('admin.students.create') }}"
           class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">
            + Ajouter un étudiant
        </a>
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
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">Aucun étudiant trouvé</td>
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
