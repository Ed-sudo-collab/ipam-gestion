<div>
    {{-- ✅ Message flash --}}
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 text-sm text-green-700 bg-green-100 border border-green-200 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- ✅ Formulaire d’ajout / édition --}}
    <div class="p-4 mb-4 bg-white border rounded-lg shadow">
        <h3 class="mb-3 text-base font-semibold text-gray-700">
            {{ $isEditing ? '✏️ Modifier un statut étudiant' : '➕ Ajouter un nouveau statut étudiant' }}
        </h3>

        <form wire:submit.prevent="save" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" wire:model.defer="libelle" placeholder="Libellé du statut"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('libelle')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}
                </button>

                @if ($isEditing)
                    <button type="button" wire:click="resetForm"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                        Annuler
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- ✅ Tableau des statuts --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Libellé</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Modifiable</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statuts as $statut)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $statut->id }}</td>
                        <td class="px-4 py-2 font-medium">{{ $statut->libelle }}</td>

                        {{-- ✅ Type avec badge coloré --}}
                        <td class="px-4 py-2">
                            @if ($statut->type === 'système')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                    Système
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                    Personnalisé
                                </span>
                            @endif
                        </td>

                        {{-- ✅ Modifiable --}}
                        <td class="px-4 py-2">
                            @if ($statut->modifiable)
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-50 text-green-700">
                                    Oui
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-700">
                                    Non
                                </span>
                            @endif
                        </td>

                        {{-- ✅ Actions --}}
                        <td class="px-4 py-2 space-x-2">
                            @if ($statut->modifiable)
                                <button wire:click="edit({{ $statut->id }})"
                                        class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                    Modifier
                                </button>

                                <button wire:click="delete({{ $statut->id }})"
                                        onclick="return confirm('Supprimer ce statut ?')"
                                        class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                    Supprimer
                                </button>
                            @else
                                <span class="text-gray-400 italic text-sm">Non modifiable</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                            Aucun statut enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 🔢 Pagination --}}
    <div class="mt-4">
        {{ $statuts->links() }}
    </div>
</div>
