<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StudentStatut as StudentStatutModel;

class StudentStatut extends Component
{
    use WithPagination;

    public $libelle;
    public $statutId;
    public $isEditing = false;

    protected $rules = [
        'libelle' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $statut = StudentStatutModel::findOrFail($this->statutId);
            $statut->update(['libelle' => $this->libelle]);
            session()->flash('message', 'Statut mis à jour ✅');
        } else {
            StudentStatutModel::create(['libelle' => $this->libelle]);
            session()->flash('message', 'Statut ajouté ✅');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $statut = StudentStatutModel::findOrFail($id);
        $this->statutId = $statut->id;
        $this->libelle = $statut->libelle;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        StudentStatutModel::findOrFail($id)->delete();
        session()->flash('message', 'Statut supprimé 🗑️');
    }

    public function resetForm()
    {
        $this->libelle = '';
        $this->statutId = null;
        $this->isEditing = false;
    }

    public function render()
    {
        $statuts = StudentStatutModel::orderBy('libelle')->paginate(10);

        return view('livewire.admin.student-statut', compact('statuts'));
    }
}
