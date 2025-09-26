<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;

class StudentGeneral extends Component
{
    public $student;

    public $matricule, $nom, $prenom, $email, $telephone;

    public $isModalOpen = false;

    protected $rules = [
        'matricule' => 'required|string|max:50|unique:students,matricule',
        'nom'       => 'required|string|max:100',
        'prenom'    => 'required|string|max:100',
        'email'     => 'nullable|email|max:150|unique:students,email',
        'telephone' => 'nullable|string|max:20',
    ];

    public function mount($student)
    {
        $this->student = $student;
        $this->fillFields();
    }

    public function fillFields()
    {
        $this->matricule = $this->student->matricule;
        $this->nom       = $this->student->nom;
        $this->prenom    = $this->student->prenom;
        $this->email     = $this->student->email;
        $this->telephone = $this->student->telephone;
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['matricule'] .= ',' . $this->student->id;
        $rules['email'] .= ',' . $this->student->id;

        $this->validate($rules);

        $this->student->update([
            'matricule' => $this->matricule,
            'nom'       => $this->nom,
            'prenom'    => $this->prenom,
            'email'     => $this->email,
            'telephone' => $this->telephone,
        ]);

        $this->emitUp('refreshStudent');
        session()->flash('message', 'Informations générales mises à jour ✅');
    }

    public function render()
    {
        return view('livewire.admin.student-general');
    }
}
