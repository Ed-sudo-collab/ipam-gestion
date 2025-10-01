<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\StudentProfessional as StudentProfessionalModel;

class StudentProfessional extends Component
{
    public $student;
    public $professional;

    // Champs pour le formulaire
    public $profession_actuelle, $employeur, $experience;

    public function mount($student)
    {
        $this->student = $student;
        $this->professional = $student->professional ?? new StudentProfessionalModel();
        $this->fillFields();
    }

    public function fillFields()
    {
        if ($this->professional && $this->professional->getKey()) {
            $this->profession_actuelle = $this->professional->profession;
            $this->employeur          = $this->professional->employeur;
            $this->experience         = $this->professional->experience;
        }
    }

    public function save()
    {
        $this->validate([
            'profession_actuelle' => 'required|string|max:150',
            'employeur'           => 'nullable|string|max:150',
            'experience'          => 'nullable|string|max:1000',
        ]);

        $this->professional = $this->student->professional()->updateOrCreate(
            ['student_id' => $this->student->id],
            [
                'profession' => $this->profession_actuelle,
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
