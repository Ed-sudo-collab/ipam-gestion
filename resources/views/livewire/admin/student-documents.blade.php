<div>
    <h3 class="mb-4 text-lg font-semibold">Documents</h3>

    @if($student->documents->count())
        <table class="min-w-full text-sm text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Nom fichier</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->documents as $doc)
                    <tr class="border-t">
                        <!-- Affiche une dénomination lisible en remplaçant les underscores par des espaces et capitalisant -->
                        <td class="px-4 py-2">{{ ucfirst(str_replace('_', ' ', $doc->type_document)) }}</td>
                        <td class="px-4 py-2">{{ basename($doc->path) }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                               class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Voir</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-gray-500">Aucun document disponible.</div>
    @endif
</div>
