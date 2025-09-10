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
    public $permissions = [];       // Permissions sélectionnées pour le rôle
    public $allPermissions = [];    // Toutes les permissions disponibles
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
    ];

    protected $paginationTheme = 'tailwind';

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
            $role = Role::find($id); // find au lieu de findOrFail pour éviter le 404
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
     */
    public function saveRole()
    {
        $rules = $this->rules;

        if ($this->roleId) {
            $rules['name'] = 'required|string|unique:roles,name,' . $this->roleId;
        }

        $this->validate($rules);

        // Création ou mise à jour du rôle
        $role = Role::updateOrCreate(
            ['id' => $this->roleId],
            ['name' => $this->name]
        );

        // Synchroniser les permissions correctement
        if (!empty($this->permissions)) {
            $permissionsNames = Permission::whereIn('id', $this->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionsNames);
        } else {
            $role->syncPermissions([]); // retirer toutes les permissions si aucune sélectionnée
        }

        session()->flash('message', $this->roleId ? 'Rôle mis à jour.' : 'Rôle créé avec succès.');

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Supprimer un rôle
     */
    public function deleteRole($id)
    {
        $role = Role::find($id); // find au lieu de findOrFail pour éviter 404
        if ($role) {
            $role->delete();
            session()->flash('message', 'Rôle supprimé.');
        } else {
            session()->flash('message', 'Rôle introuvable.');
        }
    }
}
