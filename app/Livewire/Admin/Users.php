<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $name, $email, $password, $password_confirmation, $status, $userId, $role_id;
    public $roles; // liste des rôles pour le select
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'status' => 'required|in:ACTIVE,INACTIVE,BLOCKED',
        'password' => 'required|min:8|confirmed',
        'role_id' => 'required|exists:roles,id',
    ];

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Charger tous les rôles Spatie pour le formulaire
        $this->roles = Role::all();
    }

    public function render()
    {
        $users = User::with('role')->orderBy('created_at', 'desc')->paginate(10);

        // Ajouter le rôle Spatie pour chaque utilisateur
        foreach ($users as $user) {
            $user->spatieRole = $user->getRoleNames()->first();
        }

        return view('livewire.admin.users', compact('users'));
    }

    // -------------------
    // Modal
    // -------------------
    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->status = $user->status;
            $this->role_id = $user->role_id;
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = 'ACTIVE';
        $this->userId = null;
        $this->role_id = null;
    }

    // -------------------
    // Création / Mise à jour
    // -------------------
    public function saveUser()
    {
        $rules = $this->rules;

        if ($this->userId) {
            // Pour l'édition, email unique sauf pour cet utilisateur
            $rules['email'] = 'required|email|unique:users,email,' . $this->userId;
            $rules['password'] = 'nullable|min:8|confirmed';
        }

        $this->validate($rules);

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status,
                'role_id' => $this->role_id,
            ]);

            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status,
                'role_id' => $this->role_id,
                'password' => Hash::make($this->password),
            ]);
        }

        // 🔑 Synchroniser le rôle avec Spatie
        if ($this->role_id) {
            $role = Role::find($this->role_id);
            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }

        session()->flash('message', $this->userId ? 'Utilisateur mis à jour.' : 'Utilisateur créé avec succès.');
        $this->closeModal();
        $this->resetInputFields();
    }

    // -------------------
    // Bloquer / Activer
    // -------------------
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'BLOCKED']);
        session()->flash('message', 'Utilisateur bloqué.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => $user->status === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE'
        ]);
        session()->flash('message', 'Statut modifié.');
    }
}
