<div>
    <div class="mb-6">
        <h2 class="flex items-center gap-3 text-2xl font-bold text-white">
            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
            </svg>
            Informations professionnelles
        </h2>
        <p class="mt-1 text-sm text-gray-400">Détails de l'expérience professionnelle</p>
    </div>

    @if($student->professional)
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Profession actuelle -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A4.5 4.5 0 0012.817 13H5.183A4.5 4.5 0 004 11.57V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2zM6 8a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Profession actuelle</label>
                </div>
                <p class="text-lg font-semibold text-white">{{ $student->professional->profession ?? 'Non renseigné' }}</p>
            </div>

            <!-- Employeur -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg hover:border-gray-600">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Employeur</label>
                </div>
                <p class="text-lg font-semibold text-white">{{ $student->professional->employeur ?? 'Non renseigné' }}</p>
            </div>

            <!-- Expérience -->
            <div class="p-6 transition bg-gray-800 border border-gray-700 rounded-lg md:col-span-2 hover:border-gray-600">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM14.917 9h1.946a6.004 6.004 0 01-2.783-4.118c.454 1.148.748 2.572.837 4.118zM12.403 9.823c.361-1.03.67-2.141.822-3.823h-1.955a20.094 20.094 0 01-1.08 3.823h2.213zM13.06 9c.435-1.561.959-3.06 1.546-4.423A4.998 4.998 0 0013.06 9zM6.94 9a4.998 4.998 0 00-1.546-4.423c.587 1.364 1.111 2.862 1.546 4.423zM12.403 9.177a20.07 20.07 0 001.081-3.823h-1.955c.153 1.681.464 2.792.822 3.823h1.052zM9.5 9c.165-.495.357-1.005.57-1.5a.5.5 0 00-.57 1.5zM7.597 9.823c.361-1.03.67-2.141.822-3.823H6.464c.271.895.578 1.81.915 2.816.184.51.357 1.01.57 1.5h1.048z" clip-rule="evenodd"></path>
                    </svg>
                    <label class="text-sm font-semibold text-gray-400">Expérience</label>
                </div>
                <p class="text-base leading-relaxed text-gray-300 whitespace-pre-wrap">
                    {{ $student->professional->experience ?? 'Non renseigné' }}
                </p>
            </div>
        </div>
    @else
        <div class="p-12 text-center bg-gray-800 border border-gray-700 rounded-xl">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.118 3.878A3 3 0 00.364.864h-.001a3 3 0 00-3.976 2.888 3 3 0 003 2.864h.001a3 3 0 003.976-2.864zm12.768 3.878a3 3 0 00-3.754-3.878 3 3 0 00-3.976 2.888 3 3 0 003 2.864 3 3 0 003.976-2.864zM4.118 15.878a3 3 0 00-3.754-3.878 3 3 0 00-3.976 2.888 3 3 0 003 2.864 3 3 0 003.976-2.864zm12.768 0a3 3 0 00-3.754-3.878 3 3 0 00-3.976 2.888 3 3 0 003 2.864 3 3 0 003.976-2.864z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-lg font-medium text-gray-400">Aucune information professionnelle disponible</p>
            <p class="mt-2 text-sm text-gray-500">Les informations professionnelles seront affichées ici une fois complétées.</p>
        </div>
    @endif
</div>
