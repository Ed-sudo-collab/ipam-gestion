     <div class="receipt-print max-w-3xl mx-auto bg-white text-black text-sm p-10 border border-gray-300">

            {{-- =========================
                EN-TÊTE
            ========================== --}}
            <div class="flex justify-between items-start mb-6">

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
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold uppercase underline">
                    Reçu de paiement
                </h2>
                <p class="mt-2 text-base font-semibold">
                    N° {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            {{-- =========================
                INFORMATIONS ÉTUDIANT
            ========================== --}}
            <div class="space-y-3 mb-8">

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
                    <p class="border-t border-black pt-1">
                        Signature & Cachet
                    </p>
                </div>
            </div>

            {{-- =========================
                ACTIONS
            ========================== --}}
            <div class="mt-10 text-center print:hidden">
                <button onclick="window.print()"
                    class="px-6 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">
                    Imprimer le reçu
                </button>
            </div>


    </div>


