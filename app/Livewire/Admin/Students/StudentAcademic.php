<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\StudentAcademic as StudentAcademicModel;

class StudentAcademic extends Component
{
    use WithFileUploads;

    public $student;
    public $academic;

    // Champs académiques
    public $dernier_diplome, $etablissement, $annee_obtention, $mention;

    // Fichiers
    public $diplome_file, $releves_file;

    public function mount($student)
    {
        $this->student = $student;
        $this->academic = $student->academic ?? new StudentAcademicModel();
        $this->fillFields();
    }

    public function fillFields()
    {
        if ($this->academic->exists) {
            $this->dernier_diplome   = $this->academic->dernier_diplome;
            $this->etablissement     = $this->academic->etablissement;
            $this->annee_obtention   = $this->academic->annee_obtention;
            $this->mention           = $this->academic->mention;
        }
    }

    public function save()
    {
        $this->validate([
            'dernier_diplome' => 'required|string|max:150',
            'etablissement'   => 'required|string|max:150',
            'annee_obtention' => 'required|integer|min:1900|max:' . date('Y'),
            'mention'         => 'nullable|string|max:50',
            'diplome_file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'releves_file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Upload fichiers si fournis
        $diplomePath = $this->academic->diplome_file ?? null;
        $relevesPath = $this->academic->releves_file ?? null;

        if ($this->diplome_file) {
            $diplomePath = $this->diplome_file->store('student_academics');
        }

        if ($this->releves_file) {
            $relevesPath = $this->releves_file->store('student_academics');
        }

        // Création ou mise à jour
        $this->academic = $this->student->academic()->updateOrCreate(
            ['student_id' => $this->student->id],
            [
                'dernier_diplome' => $this->dernier_diplome,
                'etablissement'   => $this->etablissement,
                'annee_obtention' => $this->annee_obtention,
                'mention'         => $this->mention,
                'diplome_file'    => $diplomePath,
                'releves_file'    => $relevesPath,
            ]
        );

        // Reset files après upload
        $this->diplome_file = null;
        $this->releves_file = null;

        $this->emitUp('refreshStudent');
        session()->flash('message', 'Informations académiques mises à jour ✅');
    }

    public function render()
    {
        return view('livewire.admin.student-academic');
    }
}
