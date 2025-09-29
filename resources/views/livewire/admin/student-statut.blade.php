<div class="p-4 bg-white rounded shadow">
    <h2 class="mb-4 text-lg font-bold">Gestion des Statuts Étudiants</h2>

    {{-- Messages --}}
    @if (session()->has('message'))
        <div class="p-2 mb-2 text-green-700 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Formulaire --}}
    <form wire:submit.prevent="save" class="flex space-x-2">
        <input type="text" wire:model="libelle"
               class="flex-1 px-3 py-2 border rounded"
               placeholder="Libellé du statut...">
        <button type="submit"
                class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">
            {{ $isEditing ? 'Mettre à jour' : 'Ajouter' }}
        </button>
        @if ($isEditing)
            <button type="button" wire:click="resetForm"
                    class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                Annuler
            </button>
        @endif
    </form>

    {{-- Tableau --}}
    <table class="w-full mt-4 text-sm border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Libellé</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($statuts as $statut)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $statut->id }}</td>
                    <td class="px-4 py-2">{{ $statut->libelle }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <button wire:click="edit({{ $statut->id }})"
                                class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                            Modifier
                        </button>
                        <button wire:click="delete({{ $statut->id }})"
                                onclick="return confirm('Supprimer ce statut ?')"
                                class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                            Supprimer
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                        Aucun statut trouvé
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $statuts->links() }}
    </div>
</div>
