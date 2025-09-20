<div>
    <!-- Message flash -->
    @if(session()->has('message'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Bouton créer -->
    <div class="flex justify-end mb-4">
        <button wire:click="openModal()"
            class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
            + Ajouter un programme
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Nom</th>
                    <th class="px-6 py-3">Niveau</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $program)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $program->name }}</td>
                        <td class="px-6 py-3">{{ $program->level->name }}</td>
                        <td class="px-6 py-3">{{ $program->description }}</td>
                        <td class="px-6 py-3 space-x-2 text-right">
                            <button wire:click="openModal({{ $program->id }})"
                                class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Éditer
                            </button>
                            <button wire:click="deleteProgram({{ $program->id }})"
                                class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Aucun programme trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $programs->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">
                {{ $program_id ? 'Éditer Programme' : 'Ajouter Programme' }}
            </h2>

            <form wire:submit.prevent="saveProgram" class="space-y-4">
                <!-- Nom -->
                <div>
                    <label class="block text-sm font-medium">Nom du programme</label>
                    <input type="text" wire:model.defer="name"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Niveau -->
                <div>
                    <label class="block text-sm font-medium">Niveau</label>
                    <select wire:model.defer="level_id"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                        <option value="">Sélectionner le niveau</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium">Description</label>
                    <textarea wire:model.defer="description"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200"></textarea>
                    @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                        {{ $program_id ? 'Mettre à jour' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
