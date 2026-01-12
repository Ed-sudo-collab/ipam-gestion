<div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">

    <!-- Message flash -->
    @if (session()->has('message'))
    <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span>{{ session('message') }}</span>
    </div>
@endif
<h1 class="mb-2 text-4xl font-bold text-white"> Gestion des utilisateurs</h1>
<!-- Bouton créer -->
<div class="flex justify-end mb-8">
    <button wire:click="openModal"
        class="flex items-center gap-2 px-6 py-3 font-semibold text-white transition duration-200 rounded-lg shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        Créer un utilisateur
    </button>
</div>

<!-- Tableau -->
<div class="overflow-hidden bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800 border-b border-gray-700">
                    <th class="px-6 py-4 font-semibold text-left text-gray-300">Nom</th>
                    <th class="px-6 py-4 font-semibold text-left text-gray-300">Email</th>
                    <th class="px-6 py-4 font-semibold text-left text-gray-300">Rôle</th>
                    <th class="px-6 py-4 font-semibold text-left text-gray-300">Statut</th>
                    <th class="px-6 py-4 font-semibold text-right text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($users as $user)
                    <tr class="transition duration-150 hover:bg-gray-800">
                        <td class="px-6 py-4 font-medium text-gray-200">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium text-indigo-200 bg-indigo-900 rounded-full">
                                {{ $user->role?->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $user->status === 'ACTIVE' ? 'bg-green-900 text-green-200' : ($user->status === 'INACTIVE' ? 'bg-yellow-900 text-yellow-200' : 'bg-red-900 text-red-200') }}">
                                ● {{ $user->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openModal({{ $user->id }})"
                                    class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded transition duration-150">Éditer</button>
                                <button wire:click="toggleStatus({{ $user->id }})"
                                    class="px-3 py-1.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-medium rounded transition duration-150">
                                    {{ $user->status === 'ACTIVE' ? 'Désactiver' : 'Activer' }}
                                </button>
                                <button wire:click="blockUser({{ $user->id }})"
                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition duration-150">Bloquer</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $users->links() }}
</div>

<!-- Modal -->
@if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-70">
        <div class="w-full max-w-lg bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-800">
                <h2 class="text-2xl font-bold text-white">
                    {{ $userId ? 'Éditer Utilisateur' : 'Créer Utilisateur' }}
                </h2>
                <p class="mt-1 text-sm text-gray-400">Remplissez les informations ci-dessous</p>
            </div>

            <!-- Modal Body -->
            <form wire:submit.prevent="saveUser" class="p-6 space-y-5">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Nom</label>
                    <input type="text" wire:model="name" placeholder="Entrez le nom complet"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    @error('name') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Email</label>
                    <input type="email" wire:model="email" placeholder="Entrez l'adresse email"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    @error('email') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Rôle</label>
                    <select wire:model="role_id"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="">-- Sélectionner un rôle --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Statut</label>
                    <select wire:model="status"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                        <option value="BLOCKED">BLOCKED</option>
                    </select>
                    @error('status') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Mot de passe</label>
                    <input type="password" wire:model="password" placeholder="Entrez un mot de passe"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    @error('password') <span class="block mt-1 text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-300">Confirmer mot de passe</label>
                    <input type="password" wire:model="password_confirmation" placeholder="Confirmez le mot de passe"
                        class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                </div>

                <!-- Modal Footer -->
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition duration-150">
                        {{ $userId ? 'Mettre à jour' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
</div>
