<div class="min-h-screen p-6 bg-gray-950">
    <div class="mx-auto space-y-6 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="mb-2 text-4xl font-bold text-white">Historique des paiements</h1>
            <p class="text-gray-400">Consultez et gérez tous les paiements</p>
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

        @if(session()->has('error'))
            <div class="flex items-center gap-3 p-4 text-red-100 bg-red-900 border border-red-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Export et Recherche -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('admin.reports.payments') }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4z"></path>
                </svg>
                Export État des Paiements (PDF)
            </a>

            <div class="flex flex-col flex-1 gap-3 md:flex-row md:flex-none">
                <div class="flex-1">
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Recherche étudiant</label>
                    <div class="relative">
                        <svg class="absolute w-5 h-5 text-gray-500 left-3 top-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                        <input type="text"
                            wire:model.live="search_student"
                            placeholder="Nom, prénom ou matricule"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    </div>
                </div>

                <div class="flex items-end">
                    <button wire:click="resetFilters"
                        class="w-full md:w-auto px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>

        <!-- Bouton Filtres avancés -->
        <button wire:click="$toggle('showFilters')"
            class="flex items-center gap-2 text-sm font-semibold text-blue-400 transition hover:text-blue-300">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 016 17v-3.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
            </svg>
            Filtres avancés
            <span>{{ $showFilters ? '▲' : '▼' }}</span>
        </button>

        <!-- Filtres avancés -->
        @if($showFilters)
            <div class="p-6 space-y-6 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
                <!-- Étudiant & Paiement -->
                <div>
                    <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                    Étudiant & Paiement
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Mode de paiement</label>
                            <select wire:model.live="payment_method_id"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                <option value="">-- Tous --</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Année académique</label>
                            <select wire:model.live="academic_year_id"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                <option value="">-- Toutes --</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Période -->
                <div>
                    <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                        <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Période
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Date exacte</label>
                            <input type="date" wire:model.live="payment_date"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Mois</label>
                            <select wire:model.live="month"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                <option value="">-- Tous --</option>
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Année</label>
                            <input type="number" wire:model.live="year"
                                placeholder="2025"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Du</label>
                            <input type="date" wire:model.live="start_date"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Au</label>
                            <input type="date" wire:model.live="end_date"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>
                    </div>
                </div>

                <!-- Montants -->
                <div>
                    <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.16 5.314l4.897-1.596.186-.061A1 1 0 0115 4v.941a6 6 0 00-6-6 1 1 0 00-.21 1.997l4.368 1.422zM15 10a1 1 0 10-2 0 1 1 0 002 0z"></path>
                        </svg>
                        Montants
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Montant exact</label>
                            <input type="number" wire:model.live="amount_exact"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Montant min</label>
                            <input type="number" wire:model.live="amount_min"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Montant max</label>
                            <input type="number" wire:model.live="amount_max"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tableau des paiements -->
        <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-800 border-b border-gray-700">
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">#</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Étudiant</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Échéances</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Montant</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Méthode</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Date</th>
                            <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800">
                        @forelse($payments as $payment)
                            <tr class="transition duration-150 hover:bg-gray-800">
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold text-gray-300 bg-gray-800 rounded">
                                        #{{ $payment->id }}
                                    </span>
                                </td>

                                <!-- Étudiant -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-white">
                                        {{ $payment->student->nom ?? '-' }} {{ $payment->student->prenom ?? '' }}
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $payment->student->matricule ?? '-' }}
                                    </div>
                                </td>

                                <!-- Échéances -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @foreach($payment->allocations as $alloc)
                                            <div class="text-xs text-gray-400">
                                                <span class="font-medium text-white">{{ $alloc->installment->label ?? '-' }}</span>
                                                <span class="text-green-400">{{ number_format($alloc->amount, 0, ',', ' ') }} FCFA</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Montant -->
                                <td class="px-6 py-4">
                                    <span class="text-lg font-bold text-green-400">
                                        {{ number_format($payment->total_amount, 0, ',', ' ') }}
                                    </span>
                                    <span class="block text-xs text-gray-500">FCFA</span>
                                </td>

                                <!-- Méthode -->
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold text-purple-200 bg-purple-900 rounded">
                                        {{ $payment->paymentMethod->name ?? '-' }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 text-gray-400">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.paymentHistoriq.show', $payment->id) }}"
                                           class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition duration-150">
                                            Voir
                                        </a>

                                        @if(auth()->user()->role_id === 1)
                                            <button wire:click="cancelPayment({{ $payment->id }})"
                                                onclick="confirm('Êtes-vous sûr de vouloir annuler ce paiement ?') || event.stopImmediatePropagation()"
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">
                                                Annuler
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                        </svg>
                                        <p>Aucun paiement trouvé</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $payments->links() }}
        </div>
    </div>
</div>
