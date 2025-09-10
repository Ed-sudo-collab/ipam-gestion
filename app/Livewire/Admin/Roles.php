<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;

    public $name, $roleId;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
    ];

    protected $paginationTheme = 'tailwind';

    // Rendu de la liste des rôles
    public function render()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.roles', compact('roles'));
    }

    // Ouvrir le modal
    public function openModal($id = null)
    {
        $this->resetInputFields();
        if ($id) {
            $role = Role::findOrFail($id);
            $this->roleId = $role->id;
            $this->name = $role->name;
        }
        $this->isModalOpen = true;
    }

    // Fermer le modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Réinitialiser les champs
    private function resetInputFields()
    {
        $this->name = '';
        $this->roleId = null;
    }

    // Créer ou mettre à jour un rôle
    public function saveRole()
    {
        $rules = $this->rules;

        // Si édition, ignorer la validation unique sur le même rôle
        if ($this->roleId) {
            $rules['name'] = 'required|string|unique:roles,name,' . $this->roleId;
        }

        $this->validate($rules);

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => $this->name]);
            session()->flash('message', 'Rôle mis à jour.');
        } else {
            Role::create(['name' => $this->name]);
            session()->flash('message', 'Rôle créé avec succès.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    // Supprimer un rôle
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        session()->flash('message', 'Rôle supprimé.');
    }
}
