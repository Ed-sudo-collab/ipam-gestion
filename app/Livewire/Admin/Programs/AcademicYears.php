<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AcademicYear;

class AcademicYears extends Component
{
    use WithPagination;

    public $libelle, $date_debut, $date_fin, $statut = 'actif';
    public $academic_year_id;
    public $isModalOpen = false;

    protected $rules = [
        'libelle' => 'required|string|max:20|unique:academic_years,libelle',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'statut' => 'required|in:actif,inactif',
    ];

    protected $paginationTheme = 'tailwind';

    /**
     * Rendu de la liste des années académiques
     */
    public function render()
    {
        $years = AcademicYear::orderBy('id','desc')->paginate(10);
        return view('livewire.admin.academic-years', compact('years'));
    }

    /**
     * Ouvrir le modal pour création ou édition
     */
    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $year = AcademicYear::find($id);
            if ($year) {
                $this->academic_year_id = $year->id;
                $this->libelle = $year->libelle;
                $this->date_debut = $year->date_debut;
                $this->date_fin = $year->date_fin;
                $this->statut = $year->statut;
            } else {
                session()->flash('message', 'Année académique introuvable.');
                return;
            }
        }

        $this->isModalOpen = true;
    }

    /**
     * Fermer le modal
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    /**
     * Réinitialiser les champs du formulaire
     */
    private function resetInputFields()
    {
        $this->libelle = '';
        $this->date_debut = '';
        $this->date_fin = '';
        $this->statut = 'actif';
        $this->academic_year_id = null;
    }

    /**
     * Créer ou mettre à jour une année académique
     */
    public function saveAcademicYear()
    {
        $rules = $this->rules;

        if ($this->academic_year_id) {
            $rules['libelle'] = 'required|string|max:20|unique:academic_years,libelle,' . $this->academic_year_id;
        }

        $this->validate($rules);

        AcademicYear::updateOrCreate(
            ['id' => $this->academic_year_id],
            [
                'libelle' => $this->libelle,
                'date_debut' => $this->date_debut,
                'date_fin' => $this->date_fin,
                'statut' => $this->statut,
            ]
        );

        session()->flash('message', $this->academic_year_id ? 'Année académique mise à jour.' : 'Année académique créée avec succès.');

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Supprimer une année académique
     */
    public function deleteAcademicYear($id)
    {
        $year = AcademicYear::find($id);
        if ($year) {
            $year->delete();
            session()->flash('message', 'Année académique supprimée.');
        } else {
            session()->flash('message', 'Année académique introuvable.');
        }
    }
}
