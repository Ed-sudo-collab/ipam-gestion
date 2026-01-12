<div class="p-6 space-y-6">

    {{-- 🧾 Titre --}}
    <h2 class="text-2xl font-bold text-gray-800">
        Historique des paiements
    </h2>

    {{-- 🔔 Messages flash --}}
    @if(session()->has('success'))
        <div class="p-3 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-3 text-red-800 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif


        {{-- Export état des paiements --}}
    <a href="{{ route('admin.reports.payments') }}"
       target="_blank"
       class="px-4 py-2 mr-2 text-white bg-green-600 rounded hover:bg-green-700">
        Export État des Paiements (PDF)
    </a>

    {{-- 🔍 RECHERCHE RAPIDE --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-end">
        <div class="w-full md:w-1/2">
            <label class="block mb-1 text-sm font-medium text-gray-700">
                Recherche étudiant
            </label>
            <input
                type="text"
                wire:model.live="search_student"
                placeholder="Nom, prénom ou matricule"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-100"
            />
        </div>

        <div>
            <button
                wire:click="resetFilters"
                class="px-4 py-2 text-sm bg-gray-200 rounded-lg hover:bg-gray-300"
            >
                Réinitialiser
            </button>
        </div>
    </div>



    {{-- Bouton --}}
    <button
        wire:click="$toggle('showFilters')"
        class="flex items-center gap-2 text-sm font-semibold text-blue-600"
    >
        🎛️ Filtres avancés
        <span>{{ $showFilters ? '▲' : '▼' }}</span>
    </button>





    {{-- 🎛️ FILTRES AVANCÉS --}}
    @if($showFilters)
    <div class="p-4 mt-4 space-y-6 bg-white rounded-lg shadow">
        <summary class="font-semibold cursor-pointer select-none">
            🎛️ Filtres avancés
        </summary>

        <div class="mt-6 space-y-8">

            {{-- 👤 ÉTUDIANT & 💳 PAIEMENT --}}
            <div>
                <h4 class="mb-3 text-sm font-semibold text-gray-600">
                    👤 Étudiant & Paiement
                </h4>

                <div class="grid gap-4 md:grid-cols-3">
                    {{-- Mode de paiement --}}
                    <div>
                        <label class="block mb-1 text-sm">Mode de paiement</label>
                        <select wire:model.live="payment_method_id"
                                class="w-full px-3 py-2 border rounded-lg">
                            <option value="">-- Tous --</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Année académique --}}
                    <div>
                        <label class="block mb-1 text-sm">Année académique</label>
                        <select wire:model.live="academic_year_id"
                                class="w-full px-3 py-2 border rounded-lg">
                            <option value="">-- Toutes --</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}">
                                    {{ $year->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- 📅 PÉRIODE --}}
            <div>
                <h4 class="mb-3 text-sm font-semibold text-gray-600">
                    📅 Période
                </h4>

                <div class="grid gap-4 md:grid-cols-5">
                    <div>
                        <label class="text-sm">Date exacte</label>
                        <input type="date" wire:model.live="payment_date"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm">Mois</label>
                        <select wire:model.live="month"
                                class="w-full px-3 py-2 border rounded-lg">
                            <option value="">-- Tous --</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="text-sm">Année</label>
                        <input type="number" wire:model.live="year"
                               placeholder="2025"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm">Du</label>
                        <input type="date" wire:model.live="start_date"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm">Au</label>
                        <input type="date" wire:model.live="end_date"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

            {{-- 💰 MONTANTS --}}
            <div>
                <h4 class="mb-3 text-sm font-semibold text-gray-600">
                    💰 Montants
                </h4>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-sm">Montant exact</label>
                        <input type="number" wire:model.live="amount_exact"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm">Montant min</label>
                        <input type="number" wire:model.live="amount_min"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-sm">Montant max</label>
                        <input type="number" wire:model.live="amount_max"
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif

    {{-- 📊 TABLEAU DES PAIEMENTS --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Étudiant</th>
                    <th class="px-3 py-2 border">Échéances</th>
                    <th class="px-3 py-2 border">Montant</th>
                    <th class="px-3 py-2 border">Méthode</th>
                    <th class="px-3 py-2 border">Date</th>
                    <th class="px-3 py-2 border">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 border">{{ $payment->id }}</td>

                        {{-- 👤 Étudiant --}}
                        <td class="px-3 py-2 border">
                            <div class="font-medium">
                                {{ $payment->student->nom ?? '-' }}
                                {{ $payment->student->prenom ?? '' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Matricule : {{ $payment->student->matricule ?? '-' }}
                            </div>
                        </td>

                        {{-- 📆 Échéances --}}
                        <td class="px-3 py-2 border">
                            @foreach($payment->allocations as $alloc)
                                <div class="text-xs">
                                    {{ $alloc->installment->label ?? '-' }} :
                                    {{ number_format($alloc->amount, 0, ',', ' ') }} FCFA
                                </div>
                            @endforeach
                        </td>

                        {{-- 💰 Montant --}}
                        <td class="px-3 py-2 font-semibold border">
                            {{ number_format($payment->total_amount, 0, ',', ' ') }} FCFA
                        </td>

                        {{-- 💳 Méthode --}}
                        <td class="px-3 py-2 border">
                            {{ $payment->paymentMethod->name ?? '-' }}
                        </td>

                        {{-- 📅 Date --}}
                        <td class="px-3 py-2 border">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                        </td>

                        {{-- ⚙️ Actions --}}
                        <td class="px-3 py-2 space-x-2 border">
                            <a href="{{ route('admin.paymentHistoriq.show', $payment->id) }}"
                               class="px-2 py-1 text-white bg-blue-500 rounded">
                                Voir
                            </a>

                            @if(auth()->user()->role_id === 1)
                                <button
                                    wire:click="cancelPayment({{ $payment->id }})"
                                    onclick="confirm('Voulez-vous vraiment annuler ce paiement ?') || event.stopImmediatePropagation()"
                                    class="px-2 py-1 text-white bg-red-500 rounded"
                                >
                                    Annuler
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            Aucun paiement trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-4">
        {{ $payments->links() }}
    </div>

</div>
