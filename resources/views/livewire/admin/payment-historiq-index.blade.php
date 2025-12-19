<div class="p-6 space-y-6">

    <h2 class="text-xl font-bold mb-4">Historique des paiements</h2>

    {{-- Messages flash --}}
    @if(session()->has('success'))
        <div class="p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    {{-- Recherche et filtres --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Recherche étudiant..."
               class="border p-2 rounded w-full">

        <input type="date" wire:model="startDate" class="border p-2 rounded w-full">
        <input type="date" wire:model="endDate" class="border p-2 rounded w-full">
    </div>

    {{-- Tableau des paiements --}}
    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-2 py-1">#</th>
                <th class="border px-2 py-1">Étudiant</th>
                <th class="border px-2 py-1">Échéances</th>
                <th class="border px-2 py-1">Montant total</th>
                <th class="border px-2 py-1">Méthode</th>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td class="border px-2 py-1">{{ $payment->id }}</td>
                    <td class="border px-2 py-1">
                        {{ $payment->student->matricule ?? '-' }} -
                        {{ $payment->student->nom ?? '-' }} {{ $payment->student->prenom ?? '' }}
                    </td>
                    <td class="border px-2 py-1">
                        @foreach($payment->allocations as $alloc)
                            <div>{{ $alloc->installment->label ?? '-' }} : {{ number_format($alloc->amount,0,',',' ') }} FCFA</div>
                        @endforeach
                    </td>
                    <td class="border px-2 py-1">{{ number_format($payment->total_amount, 0, ',', ' ') }} FCFA</td>
                    <td class="border px-2 py-1">{{ $payment->paymentMethod->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                    <td class="border px-2 py-1 space-x-2">
                        <a href="{{ route('admin.paymentHistoriq.show', $payment->id) }}"
                           class="px-2 py-1 bg-blue-500 text-white rounded">Voir</a>

                        @if(auth()->user()->role_id === 1)
                            <button wire:click="cancelPayment({{ $payment->id }})"
                                    onclick="confirm('Voulez-vous vraiment annuler ce paiement ?') || event.stopImmediatePropagation()"
                                    class="px-2 py-1 bg-red-500 text-white rounded">Annuler</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-4">Aucun paiement trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>
