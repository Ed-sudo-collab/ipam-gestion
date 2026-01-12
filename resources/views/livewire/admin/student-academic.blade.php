<div>
    <div class="mb-6">
        <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
            </svg>
            Informations académiques
        </h2>
        <p class="mt-1 text-sm text-gray-400">Antécédents et documents académiques</p>
    </div>

    @if($student->academic)
        <!-- Cartes d'informations -->
        <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2">
            <!-- Dernier diplôme -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Dernier diplôme</label>
                </div>
                <p class="text-lg font-semibold text-white">{{ $student->academic->dernier_diplome }}</p>
            </div>

            <!-- Établissement -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Établissement</label>
                </div>
                <p class="text-lg font-semibold text-white">{{ $student->academic->etablissement }}</p>
            </div>

            <!-- Année d'obtention -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Année d'obtention</label>
                </div>
                <p class="text-lg font-semibold text-white">{{ $student->academic->annee_obtention }}</p>
            </div>

            <!-- Mention -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Mention</label>
                </div>
                <p class="text-lg font-semibold text-white">{{ $student->academic->mention }}</p>
            </div>
        </div>

        <!-- Fichiers académiques -->
        <div class="mb-6">
            <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-white">
                <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                </svg>
                Fichiers académiques
            </h3>

            <div class="space-y-3">
                @if($student->academic->path_diplome)
                    <div class="overflow-hidden transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center flex-1 gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold tracking-wide text-gray-400 uppercase">Diplôme</p>
                                    <p class="text-base font-medium text-white truncate">
                                        {{ basename($student->academic->path_diplome) }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $student->academic->path_diplome) }}" target="_blank"
                               class="flex items-center flex-shrink-0 gap-2 px-4 py-2 ml-4 text-sm font-medium text-white transition duration-150 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16.243 15.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM10 16a1 1 0 100 2h1a1 1 0 100-2h-1zM5.757 15.657a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zM4.343 5.757a1 1 0 000-1.414L3.636 3.636a1 1 0 00-1.414 1.414l.707.707zM10 5a1 1 0 100-2 1 1 0 000 2z"></path>
                                </svg>
                                Ouvrir
                            </a>
                        </div>
                    </div>
                @endif

                @if($student->academic->path_releves)
                    <div class="overflow-hidden transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                        <div class="flex items-center justify-between p-4">
                            <div class="flex items-center flex-1 gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold tracking-wide text-gray-400 uppercase">Relevés</p>
                                    <p class="text-base font-medium text-white truncate">
                                        {{ basename($student->academic->path_releves) }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $student->academic->path_releves) }}" target="_blank"
                               class="flex items-center flex-shrink-0 gap-2 px-4 py-2 ml-4 text-sm font-medium text-white transition duration-150 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16.243 15.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM10 16a1 1 0 100 2h1a1 1 0 100-2h-1zM5.757 15.657a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zM4.343 5.757a1 1 0 000-1.414L3.636 3.636a1 1 0 00-1.414 1.414l.707.707zM10 5a1 1 0 100-2 1 1 0 000 2z"></path>
                                </svg>
                                Ouvrir
                            </a>
                        </div>
                    </div>
                @endif

                @if(!$student->academic->path_diplome && !$student->academic->path_releves)
                    <div class="p-6 text-center bg-gray-800 border border-gray-700 rounded-lg">
                        <p class="text-gray-400">Aucun fichier académique disponible</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="p-12 text-center bg-gray-800 border border-gray-700 rounded-xl">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
            </svg>
            <p class="text-lg font-medium text-gray-400">Aucune information académique disponible</p>
            <p class="mt-2 text-sm text-gray-500">Les informations académiques seront affichées ici une fois complétées.</p>
        </div>
    @endif
</div>
