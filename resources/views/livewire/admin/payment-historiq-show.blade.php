<div class="p-6 space-y-6">

    <h2 class="text-xl font-bold mb-4">Détail du paiement #{{ $payment->id }}</h2>

    {{-- Messages flash --}}
    @if(session()->has('success'))
        <div class="p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    {{-- Informations paiement --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
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
    <div class="border rounded p-4">
        <h3 class="font-semibold mb-2">Échéances payées</h3>
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Échéance</th>
                    <th class="border px-2 py-1">Montant payé</th>
                    <th class="border px-2 py-1">Date d'échéance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->allocations as $alloc)
                    <tr>
                        <td class="border px-2 py-1">{{ $alloc->installment->label ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ number_format($alloc->amount, 0, ',', ' ') }} FCFA</td>
                        <td class="border px-2 py-1">{{ $alloc->installment->due_date ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Actions --}}
    <div class="space-x-2">
        <a href="{{ route('admin.paymentHistoriq.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded">Retour à l'historique</a>

        @if(auth()->user()->role_id === 1)
            <button wire:click="cancelPayment"
                    onclick="confirm('Voulez-vous vraiment annuler ce paiement ?') || event.stopImmediatePropagation()"
                    class="px-4 py-2 bg-red-500 text-white rounded">Annuler ce paiement</button>
        @endif
    </div>

</div>
