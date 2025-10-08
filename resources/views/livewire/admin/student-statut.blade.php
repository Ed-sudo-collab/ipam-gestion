<table class="w-full mt-4 text-sm border-collapse">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Libellé</th>
            <th class="px-4 py-2 text-left">Type</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($statuts as $statut)
            <tr class="border-t {{ $statut->type === 'système' ? 'bg-gray-50 text-gray-500' : '' }}">
                <td class="px-4 py-2">{{ $statut->id }}</td>
                <td class="px-4 py-2">{{ $statut->libelle }}</td>
                <td class="px-4 py-2 capitalize">{{ $statut->type }}</td>
                <td class="px-4 py-2 space-x-2">
                    @if ($statut->modifiable)
                        <button wire:click="edit({{ $statut->id }})"
                            class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                            Modifier
                        </button>
                        <button wire:click="delete({{ $statut->id }})"
                            onclick="return confirm('Supprimer ce statut ?')"
                            class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                            Supprimer
                        </button>
                    @else
                        <span class="text-xs text-gray-400">Système</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                    Aucun statut trouvé
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
