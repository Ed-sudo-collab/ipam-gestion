<div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">
    <div class="mx-auto space-y-6 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="mb-2 text-4xl font-bold text-white">Gestion des frais de scolarité</h1>
            <p class="text-gray-400">Configurez et gérez les frais de scolarité par niveau</p>
        </div>

        <!-- Alerte de succès -->
        @if (session()->has('success'))
            <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="p-8 mb-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <h2 class="flex items-center gap-3 mb-2 text-2xl font-bold text-white">
                <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                </svg>
                {{ $isEdit ? 'Modifier les frais' : 'Ajouter des frais de scolarité' }}
            </h2>
            <p class="mb-6 text-sm text-gray-400">{{ $isEdit ? 'Mettez à jour les informations de frais' : 'Créez un nouveau profil de frais de scolarité' }}</p>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <!-- Niveau -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Niveau</label>
                        <select wire:model="level_id"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                            <option value="">-- Choisir --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Montant total -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Montant total (FCFA)</label>
                        <input type="number" wire:model="total_amount" placeholder="Ex: 500000"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        @error('total_amount')
                            <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nombre d'échéances -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Nombre d'échéances</label>
                        <input type="number" wire:model="installments" placeholder="Ex: 3"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        @error('installments')
                            <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition duration-150 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>

                    @if ($isEdit)
                        <button type="button" wire:click="resetForm"
                            class="flex-1 px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                            Annuler
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tableau des frais -->
        <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <div class="p-6 border-b border-gray-800">
                <h3 class="flex items-center gap-2 text-lg font-semibold text-white">
                    <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4z"></path>
                    </svg>
                    Liste des frais
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-800 border-b border-gray-700">
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Niveau</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Montant total</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Montant par échéance</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Nombre d'échéances</th>
                            <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse ($tuitionFees as $fee)
                            <tr class="transition duration-150 hover:bg-gray-800">
                                <td class="px-6 py-4 font-medium text-gray-200">
                                    <span class="px-3 py-1 text-xs font-semibold text-blue-200 bg-blue-900 rounded-full">
                                        {{ $fee->level->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-300">
                                    {{ number_format($fee->total_amount, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    {{ number_format($fee->total_amount / $fee->installments, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold text-gray-300 bg-gray-800 rounded-full">
                                        {{ $fee->installments }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="edit({{ $fee->id }})"
                                            class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded transition duration-150">
                                            Modifier
                                        </button>
                                        <button wire:click="delete({{ $fee->id }})"
                                            onclick="confirm('Êtes-vous sûr de vouloir supprimer ces frais ?') || event.stopImmediatePropagation()"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                        </svg>
                                        <p>Aucun frais de scolarité défini</p>
                                        <p class="text-xs text-gray-600">Créez votre premier profil de frais ci-dessus</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
