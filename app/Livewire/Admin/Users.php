<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $name, $email, $password, $password_confirmation, $status, $userId;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'status' => 'required|in:ACTIVE,INACTIVE,BLOCKED',
        'password' => 'required|min:8|confirmed',
    ];

    protected $paginationTheme = 'bootstrap'; // ou 'tailwind' si tu utilises Tailwind

    /**
     * Afficher la liste des utilisateurs
     */
    public function render()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.users', compact('users'));
    }

    /**
     * Ouvrir le modal pour créer ou éditer
     */
    public function openModal($id = null)
    {
        $this->resetInputFields();
        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->status = $user->status;
        }
        $this->isModalOpen = true;
    }

    /**
     * Fermer le modal
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    /**
     * Réinitialiser les champs
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = 'ACTIVE';
        $this->userId = null;
    }

    /**
     * Créer ou mettre à jour l'utilisateur
     */
    public function saveUser()
    {
        $rules = $this->rules;

        // Si on est en édition, le password n'est pas obligatoire
        if ($this->userId) {
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
            ]);
            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status,
                'password' => Hash::make($this->password),
            ]);
        }

        session()->flash('message', $this->userId ? 'Utilisateur mis à jour.' : 'Utilisateur créé avec succès.');
        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Bloquer un utilisateur
     */
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'BLOCKED']);
        session()->flash('message', 'Utilisateur bloqué.');
    }

    /**
     * Activer / désactiver un utilisateur
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => $user->status === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE'
        ]);
        session()->flash('message', 'Statut modifié.');
    }
}
