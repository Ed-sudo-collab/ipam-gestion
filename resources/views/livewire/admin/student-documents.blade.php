<div>
    <div class="mb-6">
        <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                <path d="M9 9a1 1 0 100-2 1 1 0 000 2zm0 4a1 1 0 100-2 1 1 0 000 2z"></path>
            </svg>
            Documents
        </h2>
        <p class="mt-1 text-sm text-gray-400">Fichiers et documents fournis</p>
    </div>

    @if($student->documents->count())
        <div class="space-y-3">
            @foreach($student->documents as $doc)
                <div class="overflow-hidden transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600 group">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center flex-1 gap-4">
                            <!-- Icône du type de document -->
                            <div class="flex-shrink-0">
                                @php
                                    $icon = match($doc->type_document) {
                                        'photo' => '<svg class="w-8 h-8 text-cyan-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>',
                                        'cv' => '<svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V6a1 1 0 100 2 2 2 0 01-2 2H6a2 2 0 00-2 2v3a2 2 0 002 2h2a1 1 0 100-2H6a1 1 0 01-1-1v-3z" clip-rule="evenodd"></path></svg>',
                                        'diplome' => '<svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>',
                                        'acte_naissance' => '<svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414l4 4v10.172A2 2 0 0114.172 18H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>',
                                        'cni' => '<svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4zm3 1h6v4H7V5zm6 6H7v2h6v-2z"></path></svg>',
                                        'lettre_motivation' => '<svg class="w-8 h-8 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>',
                                        default => '<svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path></svg>'
                                    };
                                @endphp
                                {!! $icon !!}
                            </div>

                            <!-- Infos du document -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold tracking-wide text-gray-400 uppercase">
                                    {{ ucfirst(str_replace('_', ' ', $doc->type_document)) }}
                                </p>
                                <p class="text-base font-medium text-white truncate">
                                    {{ basename($doc->path) }}
                                </p>
                            </div>
                        </div>

                        <!-- Bouton d'action -->
                        <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                           class="flex items-center flex-shrink-0 gap-2 px-4 py-2 ml-4 text-sm font-medium text-white transition duration-150 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM16.243 15.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM10 16a1 1 0 100 2h1a1 1 0 100-2h-1zM5.757 15.657a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zM4.343 5.757a1 1 0 000-1.414L3.636 3.636a1 1 0 00-1.414 1.414l.707.707zM10 5a1 1 0 100-2 1 1 0 000 2z"></path>
                            </svg>
                            Ouvrir
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Résumé des documents -->
        <div class="p-4 mt-6 bg-gray-800 border border-gray-700 rounded-lg">
            <p class="text-sm text-gray-400">
                <span class="font-semibold text-white">{{ $student->documents->count() }}</span> document(s) fourni(s)
            </p>
        </div>
    @else
        <div class="p-12 text-center bg-gray-800 border border-gray-700 rounded-xl">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
            </svg>
            <p class="text-lg font-medium text-gray-400">Aucun document disponible</p>
            <p class="mt-2 text-sm text-gray-500">Les documents seront affichés ici une fois téléchargés.</p>
        </div>
    @endif
</div>
