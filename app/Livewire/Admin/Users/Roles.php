<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use WithPagination;

    public $name, $roleId;
    public $permissions = [];
    public $allPermissions = [];
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
    ];

    protected $paginationTheme = 'tailwind';

    // Liste des rôles fixes
    protected $fixedRoles = ['ADMIN', 'ETUDIANT', 'SECRETAIRE', 'COMPTABLE'];

    /**
     * Charger toutes les permissions au montage du composant
     */
    public function mount()
    {
        $this->allPermissions = Permission::all();
    }

    /**
     * Rendu de la liste des rôles
     */
    public function render()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.roles', compact('roles'));
    }

    /**
     * Ouvrir le modal pour création ou édition
     */
    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $role = Role::find($id);
            if ($role) {
                $this->roleId = $role->id;
                $this->name = $role->name;
                $this->permissions = $role->permissions->pluck('id')->toArray();
            } else {
                session()->flash('message', 'Rôle introuvable.');
                return;
            }
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
     * Réinitialiser les champs du formulaire
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->roleId = null;
        $this->permissions = [];
    }

    /**
     * Créer ou mettre à jour un rôle et synchroniser ses permissions
     * Empêche la création de nouveaux rôles et la modification du nom des rôles fixes
     */
    public function saveRole()
    {
        // Empêcher la création de nouveaux rôles (seulement édition)
        if (!$this->roleId) {
            session()->flash('message', 'La création de nouveaux rôles est désactivée.');
            $this->closeModal();
            return;
        }

        $rules = $this->rules;

        $role = Role::find($this->roleId);

        // Si édition d'un rôle fixe, empêcher la modification du nom
        if ($role && in_array($role->name, $this->fixedRoles)) {
            $rules['name'] = 'required|string|in:' . $role->name;
        } else {
            $rules['name'] = 'required|string|unique:roles,name,' . $this->roleId;
        }

        $this->validate($rules);

        // Mise à jour du rôle (nom non modifiable pour les rôles fixes)
        if ($role && in_array($role->name, $this->fixedRoles)) {
            $role->name = $role->name; // nom inchangé
        } else {
            $role->name = $this->name;
        }
        $role->save();

        // Synchroniser les permissions
        if (!empty($this->permissions)) {
            $permissionsNames = Permission::whereIn('id', $this->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionsNames);
        } else {
            $role->syncPermissions([]);
        }

        session()->flash('message', 'Rôle mis à jour.');
        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Supprimer un rôle
     * Empêche la suppression des rôles fixes
     */
    public function deleteRole($id)
    {
        $role = Role::find($id);
        if ($role && in_array($role->name, $this->fixedRoles)) {
            session()->flash('message', 'Ce rôle ne peut pas être supprimé.');
            return;
        }
        if ($role) {
            $role->delete();
            session()->flash('message', 'Rôle supprimé.');
        } else {
            session()->flash('message', 'Rôle introuvable.');
        }
    }
}
