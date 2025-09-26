<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;

class Students extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Mise à jour de la recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query()
            ->where('matricule', 'like', "%{$this->search}%")
            ->orWhere('nom', 'like', "%{$this->search}%")
            ->orWhere('prenom', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->orderBy('nom')
            ->paginate($this->perPage);

        return view('livewire.admin.students', compact('students'));
    }

    // Redirige vers la page de création (wizard)
    public function create()
    {
        return redirect()->route('admin.students.create');
    }

    // Redirige vers la page de détails (wizard en mode édition)
    public function showDetails($id)
    {
        return redirect()->route('admin.students.show', $id);
    }

    // Suppression
    public function delete($id)
    {
        Student::findOrFail($id)->delete();
        session()->flash('message', 'Étudiant supprimé avec succès 🗑️');
    }
}
