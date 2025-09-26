<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\StudentProfessional as StudentProfessionalModel; // Alias pour éviter le conflit

class StudentProfessional extends Component
{
    public $student;
    public $professional;

    public $profession, $employeur, $experience;

    public function mount($student)
    {
        $this->student = $student;
        // On utilise l'alias du modèle pour éviter le conflit avec le composant
        $this->professional = $student->professional ?? new StudentProfessionalModel();
        $this->fillFields();
    }

    public function fillFields()
    {
        // Vérifie si le modèle existe en base avant de remplir les champs
        if ($this->professional && $this->professional->getKey()) {
            $this->profession = $this->professional->profession;
            $this->employeur  = $this->professional->employeur;
            $this->experience = $this->professional->experience;
        }
    }

    public function save()
    {
        $this->validate([
            'profession' => 'required|string|max:150',
            'employeur'  => 'nullable|string|max:150',
            'experience' => 'nullable|string|max:1000',
        ]);

        // Création ou mise à jour de la relation professionnelle
        $this->professional = $this->student->professional()->updateOrCreate(
            ['student_id' => $this->student->id],
            [
                'profession' => $this->profession,
                'employeur'  => $this->employeur,
                'experience' => $this->experience,
            ]
        );

        $this->emitUp('refreshStudent');
        session()->flash('message', 'Profil professionnel mis à jour ✅');
    }

    public function render()
    {
        return view('livewire.admin.student-professional');
    }
}
