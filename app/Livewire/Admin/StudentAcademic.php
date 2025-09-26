<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\StudentAcademic as StudentAcademicModel; // Alias pour éviter le conflit

class StudentAcademic extends Component
{
    public $student;
    public $academic;

    public $diplome, $etablissement, $annee_obtention, $mention;

    public function mount($student)
    {
        $this->student = $student;
        // On utilise l'alias pour le modèle
        $this->academic = $student->academic ?? new StudentAcademicModel();
        $this->fillFields();
    }

    public function fillFields()
    {
        if ($this->academic->exists) {
            $this->diplome        = $this->academic->diplome;
            $this->etablissement  = $this->academic->etablissement;
            $this->annee_obtention = $this->academic->annee_obtention;
            $this->mention        = $this->academic->mention;
        }
    }

    public function save()
    {
        $this->validate([
            'diplome' => 'required|string|max:150',
            'etablissement' => 'required|string|max:150',
            'annee_obtention' => 'required|integer|min:1900|max:' . date('Y'),
            'mention' => 'nullable|string|max:50',
        ]);

        // On utilise l'alias pour créer ou mettre à jour
        $this->academic = $this->student->academic()->updateOrCreate(
            ['student_id' => $this->student->id],
            [
                'diplome' => $this->diplome,
                'etablissement' => $this->etablissement,
                'annee_obtention' => $this->annee_obtention,
                'mention' => $this->mention,
            ]
        );

        $this->emitUp('refreshStudent');
        session()->flash('message', 'Profil académique mis à jour ✅');
    }

    public function render()
    {
        return view('livewire.admin.student-academic');
    }
}
