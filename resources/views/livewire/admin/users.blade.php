<div>
    <h2 class="mb-4">Gestion des Utilisateurs</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <button class="mb-3 btn btn-primary" wire:click="openModal">Créer un utilisateur</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" wire:click="openModal({{ $user->id }})">Éditer</button>
                        <button class="btn btn-sm btn-warning" wire:click="toggleStatus({{ $user->id }})">
                            {{ $user->status === 'ACTIVE' ? 'Désactiver' : 'Activer' }}
                        </button>
                        <button class="btn btn-sm btn-danger" wire:click="blockUser({{ $user->id }})">Bloquer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

    <!-- Modal -->
    @if($isModalOpen)
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $userId ? 'Éditer' : 'Créer' }} Utilisateur</h5>
                        <button type="button" class="close" wire:click="closeModal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveUser">
                            <div class="mb-3">
                                <label>Nom</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" wire:model="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select class="form-control" wire:model="status">
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="INACTIVE">INACTIVE</option>
                                    <option value="BLOCKED">BLOCKED</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control" wire:model="password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Confirmer Password</label>
                                <input type="password" class="form-control" wire:model="password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-success">{{ $userId ? 'Mettre à jour' : 'Créer' }}</button>
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
