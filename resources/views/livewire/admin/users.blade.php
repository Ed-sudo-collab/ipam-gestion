<div>
    <!-- Message flash -->
    @if (session()->has('message'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Bouton créer -->
    <div class="flex justify-end mb-4">
        <button wire:click="openModal"
            class="px-4 py-2 text-white transition bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
            + Créer un utilisateur
        </button>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3">Nom</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Rôle</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="transition border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-3">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">{{ $user->role?->name ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $user->status === 'ACTIVE' ? 'bg-green-100 text-green-700' : ($user->status === 'INACTIVE' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 space-x-2 text-right">
                            <button wire:click="openModal({{ $user->id }})"
                                class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Éditer</button>
                            <button wire:click="toggleStatus({{ $user->id }})"
                                class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600">
                                {{ $user->status === 'ACTIVE' ? 'Désactiver' : 'Activer' }}
                            </button>
                            <button wire:click="blockUser({{ $user->id }})"
                                class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Bloquer</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold">
                    {{ $userId ? 'Éditer Utilisateur' : 'Créer Utilisateur' }}
                </h2>

                <form wire:submit.prevent="saveUser" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Nom</label>
                        <input type="text" wire:model="name"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" wire:model="email"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Rôle</label>
                        <select wire:model="role_id"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                            <option value="">-- Sélectionner un rôle --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Statut</label>
                        <select wire:model="status"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                            <option value="BLOCKED">BLOCKED</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Mot de passe</label>
                        <input type="password" wire:model="password"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                        @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Confirmer mot de passe</label>
                        <input type="password" wire:model="password_confirmation"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Annuler</button>
                        <button type="submit"
                            class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                            {{ $userId ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
