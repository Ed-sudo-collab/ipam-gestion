<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

    public $name;
    public $guard_name = 'web';
    public $permissionId;
    public $isModalOpen = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name',
        'guard_name' => 'required|string|max:255',
    ];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $permissions = Permission::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.permissions', compact('permissions'));
    }

    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $permission = Permission::findOrFail($id);
            $this->permissionId = $permission->id;
            $this->name = $permission->name;
            $this->guard_name = $permission->guard_name;
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
        $this->guard_name = 'web';
        $this->permissionId = null;
    }

    public function savePermission()
    {
        $rules = $this->rules;

        if ($this->permissionId) {
            $rules['name'] = 'required|string|max:255|unique:permissions,name,' . $this->permissionId;
        }

        $this->validate($rules);

        if ($this->permissionId) {
            $permission = Permission::findOrFail($this->permissionId);
            $permission->update([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
            session()->flash('message', 'Permission mise à jour.');
        } else {
            Permission::create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
            session()->flash('message', 'Permission créée avec succès.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function deletePermission($id)
    {
        Permission::findOrFail($id)->delete();
        session()->flash('message', 'Permission supprimée.');
    }
}
