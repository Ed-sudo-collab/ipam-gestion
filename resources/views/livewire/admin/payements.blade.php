<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Gestion des paiements</h2>

    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Étudiant --}}
    <div class="mb-4">
        <label class="font-semibold">Étudiant</label>
        <select wire:model="student_id" class="w-full border rounded p-2">
            <option value="">-- Choisir --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">
                    {{ $student->matricule }} — {{ $student->nom }} {{ $student->prenom }}
                </option>
            @endforeach
        </select>
        @error('student_id') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    {{-- Aperçu des échéances --}}
    @if(!empty($installmentsPreview))
        <table class="w-full border mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Échéance</th>
                    <th class="border px-2 py-1">Montant</th>
                    <th class="border px-2 py-1">Payé</th>
                    <th class="border px-2 py-1">Reste</th>
                    <th class="border px-2 py-1">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($installmentsPreview as $inst)
                    <tr>
                        <td class="border px-2 py-1">{{ $inst['label'] }}</td>
                        <td class="border px-2 py-1">{{ number_format($inst['amount'], 0, ',', ' ') }}</td>
                        <td class="border px-2 py-1">{{ number_format($inst['paid'], 0, ',', ' ') }}</td>
                        <td class="border px-2 py-1">{{ number_format($inst['remaining'], 0, ',', ' ') }}</td>
                        <td class="border px-2 py-1 font-semibold">
                            {{ $inst['status'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Paiement --}}
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label>Montant payé</label>
            <input type="number" wire:model="amount_paid" class="w-full border rounded p-2">
            @error('amount_paid') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Méthode de paiement</label>
            <select wire:model="payment_method_id" class="w-full border rounded p-2">
                <option value="">-- Choisir --</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                @endforeach
            </select>
            @error('payment_method_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <button class="px-6 py-2 bg-indigo-600 text-white rounded">
            Enregistrer le paiement
        </button>
    </form>
</div>
