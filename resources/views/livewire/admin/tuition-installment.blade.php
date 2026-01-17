<div class="min-h-screen p-6 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"">
    <div class="mx-auto space-y-6 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="mb-2 text-4xl font-bold text-white">Configuration des échéances</h1>
            <p class="text-gray-400">Configurez les dates et montants des échéances de paiement</p>
        </div>

        <!-- Alerte de succès -->
        @if(session()->has('success'))
            <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Sélection des frais de scolarité -->
        <div class="p-6 mb-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <h2 class="flex items-center gap-2 mb-2 text-xl font-bold text-white">
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4z"></path>
                </svg>
                Sélectionner les frais de scolarité
            </h2>

            <select wire:model.live="tuition_fee_id"
                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                <option value="">-- Choisir des frais --</option>
                @foreach($tuitionFees as $fee)
                    <option value="{{ $fee->id }}">
                        {{ $fee->level->name }} — {{ number_format($fee->total_amount, 0, ',', ' ') }} FCFA ({{ $fee->installments }} échéances)
                    </option>
                @endforeach
            </select>

            @error('tuition_fee_id')
                <span class="block mt-2 text-xs text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <!-- Formulaire dynamique des échéances -->
        @if($tuition_fee_id && !empty($installmentsForm))
            <div class="p-8 mb-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
                <h2 class="flex items-center gap-3 mb-6 text-2xl font-bold text-white">
                    <svg class="w-6 h-6 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Détails des échéances
                </h2>

                <form wire:submit.prevent="save" class="space-y-6">
                    @foreach($installmentsForm as $index => $inst)
                        <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                            <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                                <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded-full">
                                    {{ $index + 1 }}
                                </span>
                                Échéance {{ $index + 1 }}
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <!-- Label -->
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-300">Label</label>
                                    <input type="text"
                                        wire:model="installmentsForm.{{ $index }}.label"
                                        placeholder="Ex: 1ère tranche"
                                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                </div>

                                <!-- Montant -->
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-300">Montant (FCFA)</label>
                                    <input type="number"
                                        wire:model="installmentsForm.{{ $index }}.amount"
                                        placeholder="0"
                                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                </div>

                                <!-- Date limite -->
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-300">Date limite</label>
                                    <input type="date"
                                        wire:model="installmentsForm.{{ $index }}.due_date"
                                        class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @error('installmentsForm')
                        <div class="flex items-center gap-3 p-4 text-red-100 bg-red-900 border border-red-700 rounded-lg">
                            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <button type="submit"
                        class="flex items-center justify-center w-full gap-2 px-6 py-3 mt-6 font-semibold text-white transition duration-200 rounded-lg bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Enregistrer les échéances
                    </button>
                </form>
            </div>
        @endif

        <!-- Tableau CRUD : toutes les échéances regroupées par frais -->
        <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <div class="p-6 border-b border-gray-800">
                <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
                    <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V6a1 1 0 100-2 2 2 0 01-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2h2a1 1 0 100-2H6a1 1 0 01-1-1V5z" clip-rule="evenodd"></path>
                    </svg>
                    Toutes les échéances par frais
                </h2>
            </div>

            <div class="p-6">
                @php
                    $allInstallments = \App\Models\TuitionInstallment::with('tuitionFee.level')
                        ->orderBy('tuition_fee_id')
                        ->orderBy('id')
                        ->get()
                        ->groupBy('tuition_fee_id');
                @endphp

                @if($allInstallments->isEmpty())
                    <div class="py-12 text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                        </svg>
                        <p class="text-lg text-gray-400">Aucune échéance enregistrée pour le moment</p>
                        <p class="mt-2 text-sm text-gray-600">Configurez les échéances ci-dessus pour les afficher ici</p>
                    </div>
                @else
                    <div class="space-y-8">
                        @foreach($allInstallments as $feeId => $installments)
                            <div>
                                <h3 class="p-4 mb-4 text-lg font-bold text-white bg-gray-800 border border-gray-700 rounded-lg">
                                    <span class="text-cyan-400">{{ $installments->first()->tuitionFee->level->name }}</span>
                                    <span class="mx-2 text-gray-500">—</span>
                                    <span class="font-semibold text-green-400">{{ number_format($installments->first()->tuitionFee->total_amount, 0, ',', ' ') }} FCFA</span>
                                </h3>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="bg-gray-800 border-b border-gray-700">
                                                <th class="px-6 py-3 font-semibold text-left text-gray-300"># Échéance</th>
                                                <th class="px-6 py-3 font-semibold text-left text-gray-300">Label</th>
                                                <th class="px-6 py-3 font-semibold text-left text-gray-300">Montant</th>
                                                <th class="px-6 py-3 font-semibold text-left text-gray-300">Date limite</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-700">
                                            @foreach($installments as $index => $inst)
                                                <tr class="transition duration-150 hover:bg-gray-800">
                                                    <td class="px-6 py-3">
                                                        <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-blue-600 rounded-full">
                                                            {{ $index + 1 }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-3 font-medium text-gray-300">{{ $inst->label }}</td>
                                                    <td class="px-6 py-3 font-semibold text-green-400">{{ number_format($inst->amount, 0, ',', ' ') }} FCFA</td>
                                                    <td class="px-6 py-3 text-gray-400">{{ $inst->due_date->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
