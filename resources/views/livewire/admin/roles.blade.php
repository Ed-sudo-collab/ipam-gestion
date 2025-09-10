<div>
    <!-- Message flash -->
    @if(session()->has('message'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Bouton créer -->
    <div class="flex justify-end mb-4">
        <button wire:click="openModal"
            class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
            + Créer un rôle
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Nom du rôle</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $role->name }}</td>
                        <td class="px-6 py-3 space-x-2 text-right">
                            <button wire:click="openModal({{ $role->id }})"
                                class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Éditer
                            </button>
                            <button wire:click="deleteRole({{ $role->id }})"
                                class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                            Aucun rôle trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $roles->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-lg font-semibold">
                {{ $roleId ? 'Éditer Rôle' : 'Créer Rôle' }}
            </h2>

            <form wire:submit.prevent="saveRole" class="space-y-4">
                <!-- Nom du rôle -->
                <div>
                    <label class="block text-sm font-medium">Nom du rôle</label>
                    <input type="text" wire:model="name"
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Permissions multi-select -->
                <div>
                    <label class="block text-sm font-medium">Permissions du rôle</label>
                    <select wire:model="permissions" multiple
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                        @foreach($allPermissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                    @error('permissions') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                        {{ $roleId ? 'Mettre à jour' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

</div>
