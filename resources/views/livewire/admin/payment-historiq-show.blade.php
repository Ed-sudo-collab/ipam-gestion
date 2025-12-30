<div class="p-6 space-y-6">

    <h2 class="mb-4 text-xl font-bold">Détail du paiement #{{ $payment->id }}</h2>

    {{-- Messages flash --}}
    @if(session()->has('success'))
        <div class="p-2 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="p-2 text-red-800 bg-red-100 rounded">{{ session('error') }}</div>
    @endif

    {{-- Informations paiement --}}
    <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
        <div>
            <strong>Étudiant :</strong><br>
            {{ $payment->student->matricule ?? '-' }} -
            {{ $payment->student->nom ?? '-' }} {{ $payment->student->prenom ?? '' }}
        </div>
        <div>
            <strong>Montant total :</strong> {{ number_format($payment->total_amount, 0, ',', ' ') }} FCFA
        </div>
        <div>
            <strong>Méthode :</strong> {{ $payment->paymentMethod->name ?? '-' }}
        </div>
        <div>
            <strong>Date de paiement :</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
        </div>
    </div>

    {{-- Détail des allocations --}}
    <div class="p-4 border rounded">
        <h3 class="mb-2 font-semibold">Échéances payées</h3>
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1 border">Échéance</th>
                    <th class="px-2 py-1 border">Montant payé</th>
                    <th class="px-2 py-1 border">Date d'échéance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->allocations as $alloc)
                    <tr>
                        <td class="px-2 py-1 border">{{ $alloc->installment->label ?? '-' }}</td>
                        <td class="px-2 py-1 border">{{ number_format($alloc->amount, 0, ',', ' ') }} FCFA</td>
                        <td class="px-2 py-1 border">{{ $alloc->installment->due_date ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Actions --}}
    <div class="space-x-2">
        <a href="{{ route('admin.paymentHistoriq.index') }}"
           class="px-4 py-2 text-white bg-gray-500 rounded">Retour à l'historique</a>

        @if(auth()->user()->role_id === 1)
            <button wire:click="cancelPayment"
                    onclick="confirm('Voulez-vous vraiment annuler ce paiement ?') || event.stopImmediatePropagation()"
                    class="px-4 py-2 text-white bg-red-500 rounded">Annuler ce paiement</button>
        @endif

        <a href="{{ route('admin.payment.receipt', ['paymentId' => $payment->id]) }}"
           target="_self"
           class="px-4 py-2 text-white bg-blue-600 rounded">Voir le reçu</a>

    </div>

</div>
