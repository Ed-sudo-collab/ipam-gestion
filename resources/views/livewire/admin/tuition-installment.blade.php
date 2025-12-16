<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Configuration des échéances</h2>

    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Sélection Tuition Fee --}}
    <div class="mb-4">
        <label class="font-semibold">Frais de scolarité</label>

        <select wire:model.live="tuition_fee_id" class="w-full border rounded p-2">
            <option value="">-- Choisir --</option>
            @foreach($tuitionFees as $fee)
                <option value="{{ $fee->id }}">
                    {{ $fee->level->name }} — {{ number_format($fee->total_amount, 0, ',', ' ') }} FCFA
                </option>
            @endforeach
        </select>

        @error('tuition_fee_id')
            <span class="text-red-500">{{ $message }}</span>
        @enderror



    </div>

    {{-- Formulaire dynamique des échéances --}}
    @if($tuition_fee_id && !empty($installmentsForm))
        <form wire:submit.prevent="save">
            <div class="space-y-4">
                @foreach($installmentsForm as $index => $inst)
                    <div class="border rounded p-4 bg-gray-50">
                        <h4 class="font-semibold mb-2">
                            Échéance {{ $index + 1 }}
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label>Label</label>
                                <input type="text"
                                       wire:model="installmentsForm.{{ $index }}.label"
                                       class="w-full border p-2 rounded">
                            </div>

                            <div>
                                <label>Montant</label>
                                <input type="number"
                                       wire:model="installmentsForm.{{ $index }}.amount"
                                       class="w-full border p-2 rounded">
                            </div>

                            <div>
                                <label>Date limite</label>
                                <input type="date"
                                       wire:model="installmentsForm.{{ $index }}.due_date"
                                       class="w-full border p-2 rounded">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="mt-6 px-6 py-2 bg-indigo-600 text-white rounded">
                Enregistrer les échéances
            </button>
        </form>
                @error('installmentsForm')
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ $message }}
                    </div>
                @enderror
    @endif

    {{-- Tableau CRUD : toutes les échéances regroupées par frais --}}
    <h3 class="text-lg font-bold mt-8 mb-2">Toutes les échéances par frais</h3>

    @php
        $allInstallments = \App\Models\TuitionInstallment::with('tuitionFee.level')
            ->orderBy('tuition_fee_id')
            ->orderBy('id')
            ->get()
            ->groupBy('tuition_fee_id');
    @endphp

    @if($allInstallments->isEmpty())
        <p class="text-gray-500">Aucune échéance enregistrée pour le moment.</p>
    @else
        @foreach($allInstallments as $feeId => $installments)
            <h4 class="font-semibold mt-4">
                {{ $installments->first()->tuitionFee->level->name }} —
                {{ number_format($installments->first()->tuitionFee->total_amount, 0, ',', ' ') }} FCFA
            </h4>
            <table class="w-full border mb-4">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Label</th>
                        <th class="border px-2 py-1">Montant</th>
                        <th class="border px-2 py-1">Date limite</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($installments as $inst)
                        <tr>
                            <td class="border px-2 py-1">{{ $inst->label }}</td>
                            <td class="border px-2 py-1">{{ number_format($inst->amount, 0, ',', ' ') }} FCFA</td>
                            <td class="border px-2 py-1">{{ $inst->due_date->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
</div>
