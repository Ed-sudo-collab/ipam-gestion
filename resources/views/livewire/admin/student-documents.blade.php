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
                        <td class="px-4 py-2">{{ $doc->type }}</td>
                        <td class="px-4 py-2">{{ $doc->filename }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ asset('storage/'.$doc->path) }}" target="_blank"
                               class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Voir</a>
                            <button wire:click="delete({{ $doc->id }})"
                                    onclick="return confirm('Supprimer ce document ?')"
                                    class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-gray-500">Aucun document disponible.</div>
    @endif
</div>
