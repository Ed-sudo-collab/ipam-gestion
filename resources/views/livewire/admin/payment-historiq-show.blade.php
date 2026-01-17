<div class="min-h-screen p-6 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"">
    <div class="max-w-6xl mx-auto">
        <!-- En-tête -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="mb-2 text-4xl font-bold text-white">Détail du paiement</h1>
                <p class="text-lg text-gray-400">#{{ $payment->id }}</p>
            </div>
            <div class="text-right">
                <span class="px-4 py-2 text-sm font-semibold text-green-200 bg-green-900 rounded-full">
                    ✓ Paiement reçu
                </span>
            </div>
        </div>

        <!-- Messages flash -->
        @if(session()->has('success'))
            <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="flex items-center gap-3 p-4 mb-6 text-red-100 bg-red-900 border border-red-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Informations paiement - Cartes -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
            <!-- Étudiant -->
            <div class="p-6 transition bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                    <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Étudiant</label>
                </div>
                <p class="mb-1 text-sm text-gray-300">
                    <span class="font-semibold text-white">{{ $payment->student->matricule ?? '-' }}</span>
                </p>
                <p class="text-base font-semibold text-white">
                    {{ $payment->student->nom ?? '-' }} {{ $payment->student->prenom ?? '' }}
                </p>
            </div>

            <!-- Montant total -->
            <div class="p-6 transition bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.16 5.314l4.897-1.596.186-.061A1 1 0 0115 4v.941a6 6 0 00-6-6 1 1 0 00-.21 1.997l4.368 1.422zM15 10a1 1 0 10-2 0 1 1 0 002 0z"></path>
                    </svg>
                    <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Montant total</label>
                </div>
                <p class="text-2xl font-bold text-green-400">
                    {{ number_format($payment->total_amount, 0, ',', ' ') }}
                </p>
                <p class="mt-1 text-xs text-gray-500">FCFA</p>
            </div>

            <!-- Méthode de paiement -->
            <div class="p-6 transition bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z"></path>
                    </svg>
                    <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Méthode</label>
                </div>
                <p class="text-lg font-semibold text-white">
                    {{ $payment->paymentMethod->name ?? '-' }}
                </p>
            </div>

            <!-- Date de paiement -->
            <div class="p-6 transition bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Date paiement</label>
                </div>
                <p class="text-lg font-semibold text-white">
                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                </p>
            </div>
        </div>

        <!-- Détail des allocations -->
        <div class="mb-8 overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <div class="p-6 border-b border-gray-800">
                <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
                    <svg class="w-6 h-6 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Échéances payées
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-800 border-b border-gray-700">
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Échéance</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Montant payé</th>
                            <th class="px-6 py-4 font-semibold text-left text-gray-300">Date d'échéance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($payment->allocations as $alloc)
                            <tr class="transition duration-150 hover:bg-gray-800">
                                <td class="px-6 py-4 font-medium text-gray-300">
                                    {{ $alloc->installment->label ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-green-400">
                                    {{ number_format($alloc->amount, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 text-gray-400">
                                    @if($alloc->installment && $alloc->installment->due_date)
                                        {{ \Carbon\Carbon::parse($alloc->installment->due_date)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-3 md:flex-row md:gap-2">
            <a href="{{ route('admin.paymentHistoriq.index') }}"
               class="flex items-center justify-center gap-2 px-6 py-3 font-medium text-gray-300 transition duration-150 bg-gray-800 rounded-lg hover:bg-gray-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                Retour à l'historique
            </a>

            <a href="{{ route('admin.payment.receipt', ['paymentId' => $payment->id]) }}"
               target="_self"
               class="flex items-center justify-center gap-2 px-6 py-3 font-medium text-white transition duration-150 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V6a1 1 0 100-2 2 2 0 01-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2h2a1 1 0 100-2H6a1 1 0 01-1-1V5z" clip-rule="evenodd"></path>
                </svg>
                Voir le reçu
            </a>

            @if(auth()->user()->role_id === 1)
                <button wire:click="cancelPayment"
                    onclick="confirm('Êtes-vous sûr de vouloir annuler ce paiement ? Cette action est irréversible.') || event.stopImmediatePropagation()"
                    class="flex items-center justify-center gap-2 px-6 py-3 font-medium text-white transition duration-150 bg-red-600 rounded-lg hover:bg-red-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Annuler ce paiement
                </button>
            @endif
        </div>
    </div>
</div>
