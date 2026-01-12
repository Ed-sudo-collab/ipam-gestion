<div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">
<div class="mx-auto space-y-6 max-w-7xl">
    <!-- Message flash -->
    @if(session()->has('message'))
        <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @php
        $fixedRoles = ['ADMIN', 'SECRETAIRE', 'COMPTABLE'];
    @endphp

    <h1 class="mb-2 text-4xl font-bold text-white"> Gestion des roles</h1>

    <!-- Bouton Créer -->
    <div class="flex justify-end mb-8">
        <button wire:click="openModal"
            class="flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Créer un rôle
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 border-b border-gray-700">
                        <th class="px-6 py-4 font-semibold text-left text-gray-300">Nom du rôle</th>
                        <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($roles as $role)
                        <tr class="transition duration-150 hover:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-200">{{ $role->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="openModal({{ $role->id }})"
                                        class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded transition duration-150">
                                        Éditer
                                    </button>
                                    @if(!in_array($role->name, $fixedRoles))
                                        <button wire:click="deleteRole({{ $role->id }})"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">
                                            Supprimer
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-gray-500">
                                Aucun rôle trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $roles->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-70">
            <div class="w-full max-w-lg bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
                <!-- Modal Header -->
                <div class="p-6 border-b border-gray-800">
                    <h2 class="text-2xl font-bold text-white">
                        {{ $roleId ? 'Éditer Rôle' : 'Créer Rôle' }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-400">Gérez les informations et permissions du rôle</p>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="saveRole" class="p-6 space-y-5">
                    <!-- Nom du rôle -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Nom du rôle</label>
                        <input type="text" wire:model="name" placeholder="Entrez le nom du rôle"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150"
                            @if($roleId && in_array($name, $fixedRoles)) disabled @endif>
                        @error('name') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>

                    <!-- Permissions multi-select -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Permissions du rôle</label>
                        <select wire:model="permissions" multiple
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150 min-h-32">
                            @foreach($allPermissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('permissions') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 pt-4">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition duration-150">
                            {{ $roleId ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
</div>
