<div class="p-6 space-y-6">

    <h2 class="text-xl font-bold">
        Situation financière de l’étudiant
    </h2>



@if($student_id)
    <a
        href="{{ route('admin.reports.student.financial', $student_id) }}"
        target="_blank"
        class="inline-block px-4 py-2 mt-2 text-white bg-indigo-600 rounded hover:bg-indigo-700"
    >
        📄 Situation financière (PDF)
    </a>
@endif



    {{-- =========================
     |  RECHERCHE ÉTUDIANT
     |========================= --}}
    <div class="relative max-w-xl">
        <label class="block mb-1 font-semibold">
            Rechercher un étudiant
        </label>

        <input
            type="text"
            wire:model.change="searchStudent"
            placeholder="Matricule, nom ou prénom..."
            class="w-full p-2 border rounded"
        >

        {{-- Résultats --}}
        @if(!empty($studentsResults))
            <div class="absolute z-10 w-full mt-1 overflow-hidden bg-white border rounded shadow">
                @foreach($studentsResults as $student)
                    <div
                        wire:click="selectStudent({{ $student->id }})"
                        class="px-3 py-2 cursor-pointer hover:bg-gray-100"
                    >
                        <span class="font-semibold">{{ $student->matricule }}</span>
                        — {{ $student->nom }} {{ $student->prenom }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- =======================
        IDENTITÉ ÉTUDIANT
    ======================== --}}
    @if(!empty($studentInfo))
        <div class="p-4 bg-white border rounded">
            <h3 class="mb-3 font-bold text-lg">Identité de l’étudiant</h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <strong>Matricule :</strong><br>
                    {{ $studentInfo['matricule'] }}
                </div>
                <div>
                    <strong>Nom & Prénom :</strong><br>
                    {{ $studentInfo['nom'] }} {{ $studentInfo['prenom'] }}
                </div>
                <div>
                    <strong>Statut financier :</strong><br>
                    <span class="px-2 py-1 text-sm font-semibold rounded
                        @if($studentInfo['statut_financier'] === 'A jour')
                            bg-green-100 text-green-700
                        @elseif($studentInfo['statut_financier'] === 'En retard de paiement')
                            bg-red-100 text-red-700
                        @else
                            bg-gray-100 text-gray-700
                        @endif
                    ">
                        {{ $studentInfo['statut_financier'] }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    {{-- =======================
        RÉSUMÉ PAR ANNÉE
    ======================== --}}
    @forelse($summary as $yearId => $data)
        <div class="p-4 border rounded bg-gray-50" wire:key="year-{{ $yearId }}">

            <h3 class="mb-2 text-lg font-bold">
                Année académique : {{ $data['label'] }}
            </h3>

            <p class="mb-3 text-sm text-gray-600">
                <strong>Niveau :</strong> {{ $data['level'] }}
            </p>

            {{-- Résumé financier --}}
            <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-3">
                <div>
                    <strong>Frais totaux :</strong><br>
                    {{ number_format($data['total'], 0, ',', ' ') }} FCFA
                </div>
                <div>
                    <strong>Montant payé :</strong><br>
                    {{ number_format($data['paid'], 0, ',', ' ') }} FCFA
                </div>
                <div>
                    <strong>Reste à payer :</strong><br>
                    {{ number_format($data['remaining'], 0, ',', ' ') }} FCFA
                </div>
            </div>

            {{-- =======================
                DÉTAIL DES ÉCHÉANCES
            ======================== --}}
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
                            <td class="px-2 py-1 border">
                                {{ \Carbon\Carbon::parse($row['due_date'])->format('d/m/Y') }}
                            </td>
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

            {{-- =======================
                HISTORIQUE DES PAIEMENTS
            ======================== --}}
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
                                <th class="px-2 py-1 border">Montant</th>
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
