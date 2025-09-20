<div class="p-6">
    <h1 class="mb-4 text-2xl font-bold">Gestion des Années Académiques</h1>

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
            + Ajouter une Année
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Libellé</th>
                    <th class="px-6 py-3">Début</th>
                    <th class="px-6 py-3">Fin</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($years as $year)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $year->id }}</td>
                        <td class="px-6 py-3">{{ $year->libelle }}</td>
                        <td class="px-6 py-3">{{ $year->date_debut }}</td>
                        <td class="px-6 py-3">{{ $year->date_fin }}</td>
                        <td class="px-6 py-3 capitalize">{{ $year->statut }}</td>
                        <td class="px-6 py-3 space-x-2 text-right">
                            <button wire:click="openModal({{ $year->id }})"
                                class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Modifier
                            </button>
                            <button wire:click="deleteAcademicYear({{ $year->id }})"
                                class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucune année académique trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $years->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">
                {{ $academic_year_id ? 'Modifier Année' : 'Ajouter Année' }}
            </h2>

            <form wire:submit.prevent="saveAcademicYear" class="space-y-4">
                <!-- Libellé -->
                <div>
                    <label class="block text-sm font-medium">Libellé</label>
                    <input type="text" wire:model.defer="libelle"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                    @error('libelle') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Date début -->
                <div>
                    <label class="block text-sm font-medium">Date début</label>
                    <input type="date" wire:model.defer="date_debut"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                    @error('date_debut') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Date fin -->
                <div>
                    <label class="block text-sm font-medium">Date fin</label>
                    <input type="date" wire:model.defer="date_fin"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                    @error('date_fin') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label class="block text-sm font-medium">Statut</label>
                    <select wire:model.defer="statut"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                    @error('statut') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                        {{ $academic_year_id ? 'Mettre à jour' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
