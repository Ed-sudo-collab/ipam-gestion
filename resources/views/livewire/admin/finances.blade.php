<div class="min-h-screen p-6 bg-gray-950">
    <div class="mx-auto space-y-6 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="mb-2 text-4xl font-bold text-white">Situation financière de l'étudiant</h1>
            <p class="text-gray-400">Consultez les détails financiers et l'historique des paiements</p>
        </div>

        <!-- Export PDF -->
        @if($student_id)
            <a href="{{ route('admin.reports.student.financial', $student_id) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V6a1 1 0 100-2 2 2 0 01-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2h2a1 1 0 100-2H6a1 1 0 01-1-1V5z" clip-rule="evenodd"></path>
                </svg>
                Situation financière (PDF)
            </a>
        @endif

        <!-- Recherche étudiant -->
        <div class="p-6 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <h2 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
                Rechercher un étudiant
            </h2>

            <div class="relative">
                <div class="relative">
                    <svg class="absolute w-5 h-5 text-gray-500 left-3 top-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    <input type="text"
                        wire:model.change="searchStudent"
                        placeholder="Matricule, nom ou prénom..."
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                </div>

                <!-- Résultats de recherche -->
                @if(!empty($studentsResults))
                    <div class="absolute z-10 w-full mt-1 overflow-hidden overflow-y-auto bg-gray-800 border border-gray-700 rounded-lg shadow-lg max-h-64">
                        @foreach($studentsResults as $student)
                            <div wire:click="selectStudent({{ $student->id }})"
                                class="px-4 py-3 text-gray-300 transition border-b border-gray-700 cursor-pointer hover:bg-gray-700 last:border-b-0">
                                <p class="font-semibold text-white">{{ $student->matricule }}</p>
                                <p class="text-sm text-gray-500">{{ $student->nom }} {{ $student->prenom }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Identité de l'étudiant -->
        @if(!empty($studentInfo))
            <div class="p-6 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
                <h2 class="flex items-center gap-3 mb-6 text-2xl font-bold text-white">
                    <svg class="w-6 h-6 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                    </svg>
                    Identité de l'étudiant
                </h2>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="p-4 bg-gray-800 border border-gray-700 rounded-lg">
                        <p class="mb-2 text-xs font-semibold tracking-wide text-gray-400 uppercase">Matricule</p>
                        <p class="text-lg font-bold text-white">{{ $studentInfo['matricule'] }}</p>
                    </div>

                    <div class="p-4 bg-gray-800 border border-gray-700 rounded-lg">
                        <p class="mb-2 text-xs font-semibold tracking-wide text-gray-400 uppercase">Nom & Prénom</p>
                        <p class="text-lg font-bold text-white">{{ $studentInfo['nom'] }} {{ $studentInfo['prenom'] }}</p>
                    </div>

                    <div class="p-4 bg-gray-800 border border-gray-700 rounded-lg">
                        <p class="mb-2 text-xs font-semibold tracking-wide text-gray-400 uppercase">Statut financier</p>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                            @if($studentInfo['statut_financier'] === 'A jour')
                                bg-green-900 text-green-200
                            @elseif($studentInfo['statut_financier'] === 'En retard de paiement')
                                bg-red-900 text-red-200
                            @else
                                bg-gray-700 text-gray-300
                            @endif
                        ">
                            ● {{ $studentInfo['statut_financier'] }}
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Résumé par année -->
        @forelse($summary as $yearId => $data)
            <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl" wire:key="year-{{ $yearId }}">
                <!-- En-tête de l'année -->
                <div class="p-6 bg-gray-800 border-b border-gray-800">
                    <h3 class="mb-2 text-2xl font-bold text-white">{{ $data['label'] }}</h3>
                    <p class="text-gray-400">Niveau : <span class="font-semibold text-cyan-400">{{ $data['level'] }}</span></p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Résumé financier -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="p-6 bg-gray-800 border border-gray-700 rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.16 5.314l4.897-1.596.186-.061A1 1 0 0115 4v.941a6 6 0 00-6-6 1 1 0 00-.21 1.997l4.368 1.422zM15 10a1 1 0 10-2 0 1 1 0 002 0z"></path>
                                </svg>
                                <p class="text-sm font-semibold text-gray-400">Frais totaux</p>
                            </div>
                            <p class="text-2xl font-bold text-blue-400">{{ number_format($data['total'], 0, ',', ' ') }}</p>
                            <p class="text-xs text-gray-500">FCFA</p>
                        </div>

                        <div class="p-6 bg-gray-800 border border-gray-700 rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm font-semibold text-gray-400">Montant payé</p>
                            </div>
                            <p class="text-2xl font-bold text-green-400">{{ number_format($data['paid'], 0, ',', ' ') }}</p>
                            <p class="text-xs text-gray-500">FCFA</p>
                        </div>

                        <div class="p-6 bg-gray-800 border border-gray-700 rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M13.477 14.89a6 6 0 11.707-8.514 1 1 0 11-1.414-1.414A8 8 0 100.19 12.31a1 1 0 101.415 1.413A6 6 0 0113.477 14.89z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm font-semibold text-gray-400">Reste à payer</p>
                            </div>
                            <p class="text-2xl font-bold text-red-400">{{ number_format($data['remaining'], 0, ',', ' ') }}</p>
                            <p class="text-xs text-gray-500">FCFA</p>
                        </div>
                    </div>

                    <!-- Tableau des échéances -->
                    <div>
                        <h4 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                            <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Détail des échéances
                        </h4>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-800 border-b border-gray-700">
                                        <th class="px-6 py-3 font-semibold text-left text-gray-300">Échéance</th>
                                        <th class="px-6 py-3 font-semibold text-left text-gray-300">Montant</th>
                                        <th class="px-6 py-3 font-semibold text-left text-gray-300">Payé</th>
                                        <th class="px-6 py-3 font-semibold text-left text-gray-300">Reste</th>
                                        <th class="px-6 py-3 font-semibold text-left text-gray-300">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @forelse($feesDetails[$yearId] ?? [] as $index => $row)
                                        <tr class="transition duration-150 hover:bg-gray-800" wire:key="fee-{{ $yearId }}-{{ $index }}">
                                            <td class="px-6 py-3 text-gray-300">
                                                {{ \Carbon\Carbon::parse($row['due_date'])->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-3 font-semibold text-gray-300">
                                                {{ number_format($row['amount'], 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="px-6 py-3 font-semibold text-green-400">
                                                {{ number_format($row['paid'], 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="px-6 py-3 font-semibold text-red-400">
                                                {{ number_format($row['remaining'], 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="px-6 py-3">
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                    @if($row['status'] === 'PAYÉE')
                                                        bg-green-900 text-green-200
                                                    @elseif($row['status'] === 'PARTIELLE')
                                                        bg-orange-900 text-orange-200
                                                    @else
                                                        bg-red-900 text-red-200
                                                    @endif
                                                ">
                                                    {{ $row['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                Aucune échéance trouvée
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Historique des paiements -->
                    @if(!empty($paymentsHistory[$yearId]))
                        <div>
                            <h4 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                                <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V6a1 1 0 100-2 2 2 0 01-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2h2a1 1 0 100-2H6a1 1 0 01-1-1V5z" clip-rule="evenodd"></path>
                                </svg>
                                Historique des paiements
                            </h4>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-gray-800 border-b border-gray-700">
                                            <th class="px-6 py-3 font-semibold text-left text-gray-300">Date</th>
                                            <th class="px-6 py-3 font-semibold text-left text-gray-300">Échéance</th>
                                            <th class="px-6 py-3 font-semibold text-left text-gray-300">Montant</th>
                                            <th class="px-6 py-3 font-semibold text-left text-gray-300">Méthode</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach($paymentsHistory[$yearId] as $index => $pay)
                                            <tr class="transition duration-150 hover:bg-gray-800" wire:key="payment-{{ $yearId }}-{{ $index }}">
                                                <td class="px-6 py-3 text-gray-300">
                                                    {{ \Carbon\Carbon::parse($pay['date'])->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-3 font-medium text-gray-300">
                                                    {{ $pay['label'] }}
                                                </td>
                                                <td class="px-6 py-3 font-semibold text-green-400">
                                                    {{ number_format($pay['amount'], 0, ',', ' ') }} FCFA
                                                </td>
                                                <td class="px-6 py-3">
                                                    <span class="px-3 py-1 text-xs font-semibold text-gray-300 bg-gray-800 rounded">
                                                        {{ $pay['method'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-12 text-center bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-400">Sélectionnez un étudiant</p>
                <p class="mt-2 text-sm text-gray-600">pour afficher sa situation financière</p>
            </div>
        @endforelse
    </div>
</div>
