<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Models\StudentStatut;

class Students extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $statut_id = '';
    public $perPage = 10;

    public $statuts;

    public function mount()
    {
        $this->statuts = StudentStatut::orderBy('libelle')->get();
    }

    public function render()
    {
        $students = Student::query()
            ->with('statut')

            /* 🔍 Recherche */
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('nom', 'like', "%{$this->search}%")
                      ->orWhere('prenom', 'like', "%{$this->search}%")
                      ->orWhere('matricule', 'like', "%{$this->search}%");
                });
            })

            /* 👤 Statut */
            ->when($this->statut_id !== '', function ($query) {
                $query->where('statut_id', $this->statut_id);
            })

            ->orderBy('nom')
            ->paginate($this->perPage);

        return view('livewire.admin.students', compact('students'));
    }

    public function delete($id)
    {
        Student::findOrFail($id)->delete();
        session()->flash('message', 'Étudiant supprimé avec succès 🗑️');
    }
}
