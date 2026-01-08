     <div class="max-w-5xl p-10 mx-auto text-sm text-black bg-white border border-gray-300 receipt-print">

            {{-- =========================
                EN-TÊTE
            ========================== --}}
            <div class="flex items-start justify-between mb-6">

                {{-- Logo établissement (haut droite) --}}
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo établissement" class="h-16">
                </div>
            </div>

            {{-- Informations établissement --}}
            <div class="flex justify-between mb-6">
                <div>
                    <p class="font-semibold uppercase">Institut Privé Africain Moderne</p>
                    <p>Tél : +226 70 00 00 00</p>
                    <p>Email : contact@ipam-bf.com</p>
                </div>

                <div class="text-right">
                    <p class="font-semibold uppercase">Année académique</p>
                    <p>{{ $academicYear->libelle }}</p>
                </div>
            </div>

            <hr class="my-6 border-black">

            {{-- =========================
                NUMÉRO DU REÇU
            ========================== --}}
            <div class="mb-8 text-center">
                <h2 class="text-xl font-bold underline uppercase">
                    Reçu de paiement
                </h2>
                <p class="mt-2 text-base font-semibold">
                    N° {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            {{-- =========================
                INFORMATIONS ÉTUDIANT
            ========================== --}}
            <div class="mb-8 space-y-3">

                <p>
                    <strong>Nom :</strong>
                    {{ strtoupper($student->nom) }}
                </p>

                <p>
                    <strong>Prénoms :</strong>
                    {{ $student->prenom }}
                </p>

                <p>
                    <strong>Filière :</strong>
                    {{ $program->name }}
                </p>

                <p>
                    <strong>Niveau :</strong>
                    {{ $level->name }}
                </p>

                <p>
                    <strong>Montant versé :</strong>
                    {{ number_format($payment->total_amount, 0, ',', ' ') }} FCFA
                </p>

                <p>
                    <strong>Mode de paiement :</strong>
                    {{ $payment->paymentMethod->name ?? '-' }}
                </p>

                <p>
                    <strong>Reliquat à payer :</strong>
                    {{ number_format($remainingAmount, 0, ',', ' ') }} FCFA
                </p>
            </div>

            {{-- =========================
                DATE & SIGNATURE
            ========================== --}}
            <div class="flex justify-between mt-14">

                {{-- Date --}}
                <div>
                    <p>
                        Fait à Ouagadougou, le
                        {{ $payment->payment_date->format('d/m/Y') }}
                    </p>
                </div>

                {{-- Signature --}}
                <div class="text-center">
                    <p class="mb-20 font-semibold">La Caisse</p>
                    <p class="pt-1 border-t border-black">
                        Signature & Cachet
                    </p>
                </div>
            </div>

            {{-- =========================
                ACTIONS
            ========================== --}}
            <div class="mt-10 text-center print:hidden">
                <button onclick="window.print()"
                    class="px-6 py-2 text-white bg-blue-700 rounded hover:bg-blue-800">
                    Imprimer le reçu
                </button>
            </div>


    </div>


