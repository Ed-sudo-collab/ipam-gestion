<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;

class StudentShow extends Component
{
    public $studentId;
    public $student;

    public $activeTab = 'general'; // Onglets possibles : general, academic, professional, documents

    // Écouteurs pour rafraîchir les données ou changer d'onglet depuis les sous-composants
    protected $listeners = [
        'refreshStudent' => 'loadStudent',
        'switchTab' => 'setTab'
    ];

    /**
     * Initialisation du composant avec l'ID de l'étudiant
     */
    public function mount($studentId)
    {
        $this->studentId = $studentId;
        $this->loadStudent();
    }

    /**
     * Charger l'étudiant avec toutes ses relations
     */
    public function loadStudent()
    {
        $this->student = Student::with([
            'academic',       // relation 1:1 student_academics
            'professional',   // relation 1:1 student_professionals
            'documents'       // relation 1:N student_documents
        ])->findOrFail($this->studentId);
    }

    /**
     * Changer l'onglet actif
     */
    public function setTab($tab)
    {
        $allowedTabs = ['general', 'academic', 'professional', 'documents'];
        if (in_array($tab, $allowedTabs)) {
            $this->activeTab = $tab;
        }
    }

    /**
     * Rafraîchir les données de l'étudiant depuis les sous-composants
     */
    public function refresh()
    {
        $this->loadStudent();
    }

    /**
     * Rendu de la vue
     */
    public function render()
    {
        return view('livewire.admin.student-show');
    }
}
