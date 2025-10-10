<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;

class StudentGeneral extends Component
{
    public $student;

    // Champs d’infos générales
    public $matricule, $nom, $prenom, $email, $telephone;
    public $date_naissance, $lieu_naissance, $sexe;
    public $situation_matrimoniale, $nombre_enfants;
    public $adresse, $telephone_parent;

    public $isModalOpen = false;

    protected function rules()
    {
        return [
            'matricule'              => 'required|string|max:50|unique:students,matricule,' . $this->student->id,
            'nom'                    => 'required|string|max:100',
            'prenom'                 => 'required|string|max:100',
            'email'                  => 'nullable|email|max:150|unique:students,email,' . $this->student->id,
            'telephone'              => 'nullable|string|max:20',
            'date_naissance'         => 'nullable|date',
            'lieu_naissance'         => 'nullable|string|max:150',
            'sexe'                   => 'nullable|in:M,F',
            'situation_matrimoniale' => 'nullable|string|max:100',
            'nombre_enfants'         => 'nullable|integer|min:0',
            'adresse'                => 'nullable|string|max:255',
            'telephone_parent'       => 'nullable|string|max:20',
        ];
    }

    public function mount($student)
    {
        $this->student = $student;
        $this->fillFields();
    }

    public function fillFields()
    {
        $this->matricule              = $this->student->matricule;
        $this->nom                    = $this->student->nom;
        $this->prenom                 = $this->student->prenom;
        $this->email                  = $this->student->email;
        $this->telephone              = $this->student->telephone;
        $this->date_naissance         = $this->student->date_naissance;
        $this->lieu_naissance         = $this->student->lieu_naissance;
        $this->sexe                   = $this->student->sexe;
        $this->situation_matrimoniale = $this->student->situation_matrimoniale;
        $this->nombre_enfants         = $this->student->nombre_enfants;
        $this->adresse                = $this->student->adresse;
        $this->telephone_parent       = $this->student->telephone_parent;
    }

    public function save()
    {
        $this->validate();

        $this->student->update([
            'matricule'              => $this->matricule,
            'nom'                    => $this->nom,
            'prenom'                 => $this->prenom,
            'email'                  => $this->email,
            'telephone'              => $this->telephone,
            'date_naissance'         => $this->date_naissance,
            'lieu_naissance'         => $this->lieu_naissance,
            'sexe'                   => $this->sexe,
            'situation_matrimoniale' => $this->situation_matrimoniale,
            'nombre_enfants'         => $this->nombre_enfants,
            'adresse'                => $this->adresse,
            'telephone_parent'       => $this->telephone_parent,
        ]);

        $this->emitUp('refreshStudent');
        session()->flash('message', 'Informations générales mises à jour ✅');
    }

    public function render()
    {
        return view('livewire.admin.student-general');
    }
}
