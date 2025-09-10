<div>
    @if(session()->has('message'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <button wire:click="openModal" class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">+ Créer une permission</button>
    </div>

    <table class="w-full text-sm text-left border">
        <thead class="text-xs uppercase bg-gray-100">
            <tr>
                <th class="px-6 py-3">Nom</th>
                <th class="px-6 py-3">Guard</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $permission)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $permission->name }}</td>
                    <td class="px-6 py-3">{{ $permission->guard_name }}</td>
                    <td class="px-6 py-3 space-x-2 text-right">
                        <button wire:click="openModal({{ $permission->id }})" class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Éditer</button>
                        <button wire:click="deletePermission({{ $permission->id }})" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Supprimer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune permission trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $permissions->links() }}</div>

    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="w-full max-w-lg p-6 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-lg font-semibold">{{ $permissionId ? 'Éditer Permission' : 'Créer Permission' }}</h2>
                <form wire:submit.prevent="savePermission" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Nom</label>
                        <input type="text" wire:model="name" class="w-full px-3 py-2 border rounded">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Guard</label>
                        <input type="text" wire:model="guard_name" class="w-full px-3 py-2 border rounded">
                        @error('guard_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">{{ $permissionId ? 'Mettre à jour' : 'Créer' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
