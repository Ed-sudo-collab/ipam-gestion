<div>
    {{-- Messages flash --}}
    @if (session()->has('message'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Barre d'actions --}}
    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model="search" placeholder="Rechercher..."
               class="px-3 py-2 border rounded-lg" />
        <button wire:click="openModal"
                class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">
            + Ajouter étudiant
        </button>
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
                            <button wire:click="edit({{ $student->id }})"
                                    class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Modifier
                            </button>
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

    {{-- Modal création / modification --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="w-1/3 p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-lg font-semibold">
                    {{ $student_id ? 'Modifier étudiant' : 'Ajouter étudiant' }}
                </h2>

                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Matricule</label>
                        <input type="text" wire:model="matricule" class="w-full px-3 py-2 bg-gray-100 border rounded" readonly />
                        @error('matricule') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nom</label>
                        <input type="text" wire:model="nom" class="w-full px-3 py-2 border rounded" />
                        @error('nom') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Prénom</label>
                        <input type="text" wire:model="prenom" class="w-full px-3 py-2 border rounded" />
                        @error('prenom') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" wire:model="email" class="w-full px-3 py-2 border rounded" />
                        @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Téléphone</label>
                        <input type="text" wire:model="telephone" class="w-full px-3 py-2 border rounded" />
                        @error('telephone') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
