<div>
    <h3 class="mb-4 text-lg font-semibold">Informations académiques</h3>

    @if($student->academic)
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><strong>Dernier diplôme:</strong> {{ $student->academic->dernier_diplome }}</div>
            <div><strong>Établissement:</strong> {{ $student->academic->etablissement }}</div>
            <div><strong>Année d'obtention:</strong> {{ $student->academic->annee_obtention }}</div>
            <div><strong>Mention:</strong> {{ $student->academic->mention }}</div>
        </div>

        {{-- Tableau pour les fichiers académiques --}}
        <table class="min-w-full text-sm text-left border mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Type de fichier</th>
                    <th class="px-4 py-2">Nom du fichier</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($student->academic->path_diplome)
                    <tr class="border-t">
                        <td class="px-4 py-2">Diplôme</td>
                        <td class="px-4 py-2">{{ basename($student->academic->path_diplome) }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ asset('storage/' . $student->academic->path_diplome) }}" target="_blank"
                               class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Voir</a>
                        </td>
                    </tr>
                @endif
                @if($student->academic->path_releves)
                    <tr class="border-t">
                        <td class="px-4 py-2">Relevés</td>
                        <td class="px-4 py-2">{{ basename($student->academic->path_releves) }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ asset('storage/' . $student->academic->path_releves) }}" target="_blank"
                               class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Voir</a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    @else
        <div class="text-gray-500 mb-6">Aucune information académique disponible.</div>
    @endif


</div>
