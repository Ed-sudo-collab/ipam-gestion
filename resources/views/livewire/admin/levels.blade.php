<div class="p-6">
    <h1 class="mb-4 text-2xl font-bold">Gestion des Niveaux</h1>

    <!-- Message flash -->
    @if(session()->has('message'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Bouton Ajouter -->
    <div class="flex justify-end mb-4">
        <button wire:click="openModal"
            class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
            + Ajouter un Niveau
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nom</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($levels as $level)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $level->id }}</td>
                        <td class="px-6 py-3">{{ $level->name }}</td>
                        <td class="px-6 py-3 space-x-2 text-right">
                            <button wire:click="openModal({{ $level->id }})"
                                class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Modifier
                            </button>
                            <button wire:click="deleteLevel({{ $level->id }})"
                                class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Aucun niveau trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $levels->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">
                {{ $level_id ? 'Modifier Niveau' : 'Ajouter Niveau' }}
            </h2>

            <form wire:submit.prevent="saveLevel" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium">Nom du niveau</label>
                    <input type="text" wire:model.defer="name"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                        {{ $level_id ? 'Mettre à jour' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
