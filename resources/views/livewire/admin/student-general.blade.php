<div>
    <div class="mb-6">
        <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
            </svg>
            Informations générales
        </h2>
        <p class="mt-1 text-sm text-gray-400">Détails personnels de l'étudiant</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        <!-- Matricule -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Matricule</label>
            </div>
            <p class="text-lg font-bold text-white">{{ $student->matricule }}</p>
        </div>

        <!-- Nom -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Nom</label>
            </div>
            <p class="text-lg font-bold text-white">{{ $student->nom }}</p>
        </div>

        <!-- Prénom -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Prénom</label>
            </div>
            <p class="text-lg font-bold text-white">{{ $student->prenom }}</p>
        </div>

        <!-- Email -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Email</label>
            </div>
            <p class="text-sm font-semibold text-white break-all">{{ $student->email }}</p>
        </div>

        <!-- Téléphone -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.81.815 1.578 1.388 2.253.574.676 1.157 1.25 1.742 1.721.54.43 1.036.785 1.489 1.067.452.281.958.519 1.516.71.558.192 1.088.29 1.589.29.5 0 1.03-.098 1.589-.29.558-.191 1.064-.429 1.516-.71.453-.282.949-.637 1.489-1.067.585-.471 1.168-1.045 1.742-1.721.573-.675 1.042-1.443 1.388-2.253l-1.548-.773a1 1 0 01-.54-1.06l.74-4.435a1 1 0 01.986-.836h2.153a1 1 0 011 1v2.394c0 .406-.168.798-.464 1.075.188.248.29.54.29.86 0 .946-.765 1.711-1.711 1.711-.946 0-1.711-.765-1.711-1.711 0-.32.102-.612.29-.86a1.49 1.49 0 00-.464-1.075V3z"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Téléphone</label>
            </div>
            <p class="text-lg font-bold text-white">{{ $student->telephone }}</p>
        </div>

        <!-- Date de naissance -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Date de naissance</label>
            </div>
            <p class="text-lg font-bold text-white">{{ $student->date_naissance ?? '-' }}</p>
        </div>

        <!-- Lieu de naissance -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Lieu de naissance</label>
            </div>
            <p class="text-base font-semibold text-white">{{ $student->lieu_naissance ?? '-' }}</p>
        </div>

        <!-- Sexe -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5m-15-4h4m-4 4h10m-10 4h10m-10 4h4"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Sexe</label>
            </div>
            <p class="text-base font-semibold text-white">
                {{ $student->sexe === 'M' ? '♂ Masculin' : ($student->sexe === 'F' ? '♀ Féminin' : '-') }}
            </p>
        </div>

        <!-- Situation matrimoniale -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Situation matrimoniale</label>
            </div>
            <p class="text-base font-semibold text-white">{{ $student->situation_matrimoniale ?? '-' }}</p>
        </div>

        <!-- Nombre d'enfants -->
        <div class="p-4 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.172 4.172a4 4 0 015.656 0L10 5.343l.172-.171a4 4 0 115.656 5.656L10 16.657l-5.828-5.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
                <label class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Enfants</label>
            </div>
            <p class="text-lg font-bold text-white">{{ $student->nombre_enfants ?? '-' }}</p>
        </div>
    </div>
</div>
