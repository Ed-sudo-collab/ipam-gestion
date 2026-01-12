<div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">
<div class="mx-auto space-y-6 max-w-7xl">
    {{-- Message flash --}}
    @if (session()->has('message'))
        <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Formulaire d'ajout / édition --}}
    <div class="p-6 mb-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        <h2 class="mb-2 text-2xl font-bold text-white">
            {{ $isEditing ? 'Modifier un statut étudiant' : 'Ajouter un nouveau statut étudiant' }}
        </h2>
        <p class="mb-6 text-sm text-gray-400">{{ $isEditing ? 'Mettez à jour les informations du statut' : 'Créez un nouveau statut étudiant personnalisé' }}</p>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Libellé du statut</label>
                    <input type="text" wire:model.defer="libelle" placeholder="Ex: En cours de paiement"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    @error('libelle')
                        <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col justify-end gap-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition duration-150 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>

                    @if ($isEditing)
                        <button type="button" wire:click="resetForm"
                            class="px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                            Annuler
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Tableau des statuts --}}
    <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 border-b border-gray-700">
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">#</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Libellé</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Type</th>
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Modifiable</th>
                        <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($statuts as $statut)
                        <tr class="transition duration-150 hover:bg-gray-800">
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium text-gray-300 bg-gray-800 rounded">
                                    #{{ $statut->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-200">{{ $statut->libelle }}</td>

                            {{-- Type avec badge coloré --}}
                            <td class="px-6 py-4">
                                @if ($statut->type === 'système')
                                    <span class="px-3 py-1 text-xs font-semibold text-red-200 bg-red-900 rounded-full">
                                        ● Système
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold text-green-200 bg-green-900 rounded-full">
                                        ● Personnalisé
                                    </span>
                                @endif
                            </td>

                            {{-- Modifiable --}}
                            <td class="px-6 py-4">
                                @if ($statut->modifiable)
                                    <span class="px-3 py-1 text-xs font-semibold text-green-200 bg-green-900 rounded-full">
                                        ✓ Oui
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold text-gray-400 bg-gray-700 rounded-full">
                                        ✗ Non
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @if ($statut->modifiable)
                                        <button wire:click="edit({{ $statut->id }})"
                                            class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded transition duration-150">
                                            Modifier
                                        </button>

                                        <button wire:click="delete({{ $statut->id }})"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?')"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">
                                            Supprimer
                                        </button>
                                    @else
                                        <span class="text-xs italic text-gray-500">Non modifiable</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Aucun statut enregistré
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $statuts->links() }}
    </div>
</div>
</div>
