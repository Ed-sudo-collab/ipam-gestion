<div class="max-w-2xl p-10 mx-auto text-sm text-black bg-white border border-gray-300 attestation-print">

    {{-- =========================
        EN-TÊTE
    ========================== --}}
    <div class="flex items-start justify-between mb-6">

              {{-- Infos établissement (haut gauche) --}}
        <div class="space-y-1 text-sm text-left">
            <p class="font-bold uppercase">INSTITUT PRIVÉ AFRICAIN MODERNE</p>
            <p>Boîte Postale : BP 1234 Ouagadougou</p>
            <p>Tél : +226 70 00 00 00</p>
            <p>Email : contact@ipam-bf.com</p>
        </div>

        {{-- Logo établissement (haut droite) --}}
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo IPAM" class="h-20">
        </div>


    </div>

    <hr class="my-6 border-black">

    {{-- =========================
        TITRE
    ========================== --}}
    <div class="mb-8 text-center">
        <h2 class="text-xl font-bold underline uppercase">
            ATTESTATION D'INSCRIPTION
        </h2>
    </div>

    {{-- =========================
        INFORMATIONS ÉTUDIANT
    ========================== --}}
    <div class="mb-8 space-y-4 text-justify">

        <p>
            Je soussigné(e), le Directeur de l’
            <span class="font-semibold">Institut Privé Africain Moderne (IPAM)</span>,
            atteste par la présente que :
        </p>

        <p class="pl-6">
            <span class="font-semibold">Nom :</span> {{ strtoupper($student->nom) }} <br>
            <span class="font-semibold">Prénoms :</span> {{ $student->prenom }} <br>
            <span class="font-semibold">Né(e) le :</span> {{ \Carbon\Carbon::parse($student->date_naissance)->format('d/m/Y') }}
            à {{ $student->lieu_naissance }} <br>
            <span class="font-semibold">Matricule :</span> {{ $student->matricule }}
        </p>

        <p>
            est régulièrement inscrit(e) à l’
            <span class="font-semibold">Institut Privé Africain Moderne</span>
            au titre de l’année académique<br>
            <span class="font-semibold">{{ $academicYear->libelle }}</span>,
            en <span class="font-semibold">{{ $level->name }}</span>
            du programme <span class="font-semibold">{{ $program->name }}</span>.
        </p>

        <p>
            La présente attestation est délivrée pour servir et valoir ce que de droit.
        </p>

    </div>

    {{-- =========================
        PIED DE PAGE
    ========================== --}}
    <div class="flex justify-between mt-16 text-sm">

        {{-- NB --}}
        <div class="italic">
            <p>
                <span class="font-semibold">NB :</span> .......................................................
            </p>
        </div>

        {{-- Date & signature --}}
        <div class= "text-right">
            <p>Fait à Ouagadougou, le {{ now()->format('d/m/Y') }}</p>
            <p class="mt-10 font-semibold">Le Directeur</p>
        </div>
    </div>

    {{-- =========================
        BOUTON IMPRIMER
    ========================== --}}
    <div class= "mt-10 text-center print:hidden">
        <button onclick="window.print()"
            class="px-6 py-2 text-white bg-blue-700 rounded hover:bg-blue-800">
            🖨 Imprimer l'attestation
        </button>
    </div>



</div>



