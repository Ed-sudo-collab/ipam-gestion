<div class="container">

    <h4 class="mb-4">Gestion des frais de scolarité</h4>

    {{-- ALERT --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <div class="card mb-4">
        <div class="card-header">
            {{ $isEdit ? 'Modifier les frais' : 'Ajouter des frais de scolarité' }}
        </div>

        <div class="card-body">
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                <div class="row">

                    {{-- Niveau --}}
                    <div class="col-md-4 mb-3">
                        <label>Niveau</label>
                        <select wire:model="level_id" class="form-control">
                            <option value="">-- Choisir --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Montant total --}}
                    <div class="col-md-4 mb-3">
                        <label>Montant total</label>
                        <input type="number" wire:model="total_amount" class="form-control">
                        @error('total_amount') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nombre d’échéances --}}
                    <div class="col-md-4 mb-3">
                        <label>Nombre d’échéances</label>
                        <input type="number" wire:model="installments" class="form-control">
                        @error('installments') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">
                        {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>

                    @if ($isEdit)
                        <button type="button" wire:click="resetForm" class="btn btn-secondary">
                            Annuler
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header">Liste des frais</div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Niveau</th>
                        <th>Montant total</th>
                        <th>Échéances</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tuitionFees as $fee)
                        <tr>
                            <td>{{ $fee->level->name }}</td>
                            <td>{{ number_format($fee->total_amount, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $fee->installments }}</td>
                            <td>
                                <button wire:click="edit({{ $fee->id }})" class="btn btn-sm btn-warning">
                                    Modifier
                                </button>
                                <button wire:click="delete({{ $fee->id }})"
                                        onclick="confirm('Supprimer ?') || event.stopImmediatePropagation()"
                                        class="btn btn-sm btn-danger">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun frais défini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
