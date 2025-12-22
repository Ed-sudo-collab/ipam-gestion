<div class="p-6 space-y-6">

    <h2 class="text-xl font-bold">
        Situation financière de l’étudiant
    </h2>

    {{-- Sélection étudiant --}}
    <div>
        <label class="font-semibold">Étudiant</label>
        <select wire:model.change="student_id" class="w-full p-2 border rounded">
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
        <div class="p-4 border rounded bg-gray-50" wire:key="year-{{ $yearId }}">

            <h3 class="mb-3 text-lg font-bold">
                Année académique : {{ $data['label'] }}
            </h3>

            {{-- Résumé total --}}
            <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-3">
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
            <table class="w-full mb-4 border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-2 py-1 border">Échéance</th>
                        <th class="px-2 py-1 border">Montant</th>
                        <th class="px-2 py-1 border">Payé</th>
                        <th class="px-2 py-1 border">Reste</th>
                        <th class="px-2 py-1 border">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feesDetails[$yearId] ?? [] as $index => $row)
                        <tr wire:key="fee-{{ $yearId }}-{{ $index }}">
                            <td class="px-2 py-1 border">{{ $row['label'] }}</td>
                            <td class="px-2 py-1 border">
                                {{ number_format($row['amount'], 0, ',', ' ') }}
                            </td>
                            <td class="px-2 py-1 border">
                                {{ number_format($row['paid'], 0, ',', ' ') }}
                            </td>
                            <td class="px-2 py-1 border">
                                {{ number_format($row['remaining'], 0, ',', ' ') }}
                            </td>
                            <td class="px-2 py-1 font-semibold border">
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
                            <td colspan="5" class="p-3 text-center text-gray-500">
                                Aucune échéance trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Historique des paiements (via allocations) --}}
            @if(!empty($paymentsHistory[$yearId]))
                <div class="p-4 bg-white border rounded">
                    <h4 class="mb-2 font-semibold">
                        Historique des paiements
                    </h4>

                    <table class="w-full border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-1 border">Date</th>
                                <th class="px-2 py-1 border">Échéance</th>
                                <th class="px-2 py-1 border">Montant affecté</th>
                                <th class="px-2 py-1 border">Méthode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsHistory[$yearId] as $index => $pay)
                                <tr wire:key="payment-{{ $yearId }}-{{ $index }}">
                                    <td class="px-2 py-1 border">
                                        {{ \Carbon\Carbon::parse($pay['date'])->format('d/m/Y') }}
                                    </td>
                                    <td class="px-2 py-1 border">
                                        {{ $pay['label'] }}
                                    </td>
                                    <td class="px-2 py-1 border">
                                        {{ number_format($pay['amount'], 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="px-2 py-1 border">
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
        <div class="py-6 text-center text-gray-500">
            Sélectionnez un étudiant pour afficher sa situation financière.
        </div>
    @endforelse

</div>
