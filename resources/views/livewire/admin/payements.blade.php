<div class="min-h-screen p-6 bg-gray-950">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="mb-2 text-4xl font-bold text-white">Gestion des paiements</h1>
            <p class="text-gray-400">Enregistrez et gérez les paiements des étudiants</p>
        </div>

        <!-- Messages flash -->
        @if(session()->has('success'))
            <div class="flex items-center gap-3 p-4 text-green-100 bg-green-900 border border-green-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Sélection étudiant -->
        <div class="p-6 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <h2 class="flex items-center gap-2 mb-4 text-xl font-bold text-white">
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                </svg>
                Sélectionner l'étudiant
            </h2>

            <select wire:model="student_id"
                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                <option value="">-- Choisir un étudiant --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->matricule }} — {{ $student->nom }} {{ $student->prenom }}
                    </option>
                @endforeach
            </select>
            @error('student_id')
                <span class="block mt-2 text-xs text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <!-- Aperçu des échéances -->
        @if(!empty($installmentsPreview))
            <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
                <div class="p-6 border-b border-gray-800">
                    <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
                        <svg class="w-6 h-6 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Aperçu des échéances
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-800 border-b border-gray-700">
                                <th class="px-6 py-4 font-semibold text-left text-gray-300">Échéance</th>
                                <th class="px-6 py-4 font-semibold text-left text-gray-300">Montant</th>
                                <th class="px-6 py-4 font-semibold text-left text-gray-300">Montant payé</th>
                                <th class="px-6 py-4 font-semibold text-left text-gray-300">Reste à payer</th>
                                <th class="px-6 py-4 font-semibold text-left text-gray-300">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($installmentsPreview as $inst)
                                <tr class="transition duration-150 hover:bg-gray-800">
                                    <td class="px-6 py-4 font-medium text-gray-300">{{ $inst['label'] }}</td>
                                    <td class="px-6 py-4 font-semibold text-white">
                                        {{ number_format($inst['amount'], 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-green-400">
                                            {{ number_format($inst['paid'], 0, ',', ' ') }} FCFA
                                        </div>
                                        @if($inst['paid'] > 0)
                                            <div class="mt-1 text-xs text-gray-500">
                                                {{ implode(', ', array_map(fn($a) => number_format($a['amount'],0,',',' ').' FCFA', $inst['allocations'] ?? [])) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-red-400">
                                        {{ number_format($inst['remaining'], 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                            @if($inst['status'] === 'PAYÉE')
                                                bg-green-900 text-green-200
                                            @elseif($inst['status'] === 'PARTIELLE')
                                                bg-orange-900 text-orange-200
                                            @else
                                                bg-red-900 text-red-200
                                            @endif
                                        ">
                                            ● {{ $inst['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Formulaire de paiement -->
        <div class="p-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <h2 class="flex items-center gap-3 mb-6 text-2xl font-bold text-white">
                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.16 5.314l4.897-1.596.186-.061A1 1 0 0115 4v.941a6 6 0 00-6-6 1 1 0 00-.21 1.997l4.368 1.422zM15 10a1 1 0 10-2 0 1 1 0 002 0z"></path>
                </svg>
                Enregistrer un paiement
            </h2>

            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Montant payé -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Montant payé (FCFA)</label>
                    <div class="relative">
                        <svg class="absolute w-5 h-5 text-gray-500 left-3 top-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.16 5.314l4.897-1.596.186-.061A1 1 0 0115 4v.941a6 6 0 00-6-6 1 1 0 00-.21 1.997l4.368 1.422zM15 10a1 1 0 10-2 0 1 1 0 002 0z"></path>
                        </svg>
                        <input type="number"
                            wire:model="amount_paid"
                            placeholder="Ex: 150000"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    </div>
                    @error('amount_paid')
                        <span class="block mt-2 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Méthode de paiement -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Méthode de paiement</label>
                    <select wire:model="payment_method_id"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="">-- Choisir une méthode --</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>
                    @error('payment_method_id')
                        <span class="block mt-2 text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bouton de soumission -->
                <button type="submit"
                    class="flex items-center justify-center w-full gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Enregistrer le paiement
                </button>
            </form>
        </div>
    </div>
</div>
