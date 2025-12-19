<div class="p-6 space-y-6">

    <h2 class="text-xl font-bold">
        Situation financière de l’étudiant
    </h2>

    {{-- Sélection étudiant --}}
    <div>
        <label class="font-semibold">Étudiant</label>
        <select wire:model="student_id" class="w-full border rounded p-2">
            <option value="">-- Choisir un étudiant --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">
                    {{ $student->matricule }} — {{ $student->nom }} {{ $student->prenom }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Résumé par année académique --}}
    @forelse($summary as $yearId => $data)
        <div class="border rounded p-4 bg-gray-50" wire:key="year-{{ $yearId }}">

            <h3 class="font-bold text-lg mb-3">
                Année académique : {{ $data['label'] }}
            </h3>

            {{-- Résumé total --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <strong>Total :</strong>
                    {{ number_format($data['total'], 0, ',', ' ') }} FCFA
                </div>
                <div>
                    <strong>Payé :</strong>
                    {{ number_format($data['paid'], 0, ',', ' ') }} FCFA
                </div>
                <div>
                    <strong>Reste :</strong>
                    {{ number_format($data['remaining'], 0, ',', ' ') }} FCFA
                </div>
            </div>

            {{-- Détails des échéances --}}
            <table class="w-full border mb-4">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-2 py-1">Échéance</th>
                        <th class="border px-2 py-1">Montant</th>
                        <th class="border px-2 py-1">Payé</th>
                        <th class="border px-2 py-1">Reste</th>
                        <th class="border px-2 py-1">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feesDetails[$yearId] ?? [] as $index => $row)
                        <tr wire:key="fee-{{ $yearId }}-{{ $index }}">
                            <td class="border px-2 py-1">{{ $row['label'] }}</td>
                            <td class="border px-2 py-1">
                                {{ number_format($row['amount'], 0, ',', ' ') }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ number_format($row['paid'], 0, ',', ' ') }}
                            </td>
                            <td class="border px-2 py-1">
                                {{ number_format($row['remaining'], 0, ',', ' ') }}
                            </td>
                            <td class="border px-2 py-1 font-semibold">
                                <span class="
                                    @if($row['status'] === 'PAYÉE') text-green-600
                                    @elseif($row['status'] === 'PARTIELLE') text-orange-500
                                    @else text-red-600
                                    @endif
                                ">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-3 text-gray-500">
                                Aucune échéance trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Historique des paiements (via allocations) --}}
            @if(!empty($paymentsHistory[$yearId]))
                <div class="border rounded p-4 bg-white">
                    <h4 class="font-semibold mb-2">
                        Historique des paiements
                    </h4>

                    <table class="w-full border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-2 py-1">Date</th>
                                <th class="border px-2 py-1">Échéance</th>
                                <th class="border px-2 py-1">Montant affecté</th>
                                <th class="border px-2 py-1">Méthode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsHistory[$yearId] as $index => $pay)
                                <tr wire:key="payment-{{ $yearId }}-{{ $index }}">
                                    <td class="border px-2 py-1">
                                        {{ \Carbon\Carbon::parse($pay['date'])->format('d/m/Y') }}
                                    </td>
                                    <td class="border px-2 py-1">
                                        {{ $pay['label'] }}
                                    </td>
                                    <td class="border px-2 py-1">
                                        {{ number_format($pay['amount'], 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="border px-2 py-1">
                                        {{ $pay['method'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    @empty
        <div class="text-gray-500 text-center py-6">
            Sélectionnez un étudiant pour afficher sa situation financière.
        </div>
    @endforelse

</div>
