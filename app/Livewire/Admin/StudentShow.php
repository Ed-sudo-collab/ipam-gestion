<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;

class StudentShow extends Component
{
    public $studentId;
    public $student;

    public $mode = 'view'; // Modes : 'create', 'edit', 'view'
    public $activeTab = 'general'; // Onglets : general, academic, professional, documents

    // Écouteurs pour rafraîchir les données ou changer d'onglet depuis les sous-composants
    protected $listeners = [
        'refreshStudent' => 'loadStudent',
        'switchTab' => 'setTab'
    ];

    /**
     * Initialisation du composant
     *
     * @param int|null $studentId
     * @param string $mode
     */
    public function mount($studentId = null, $mode = 'view')
    {
        $this->mode = $mode;

        if ($studentId) {
            $this->studentId = $studentId;
            $this->loadStudent();
        } else {
            // Création : nouveau modèle vide
            $this->student = new Student();
            $this->mode = 'create';
        }
    }

    /**
     * Charger l'étudiant avec toutes ses relations
     */
    public function loadStudent()
    {
        if ($this->studentId) {
            $this->student = Student::with([
                'academic',       // relation 1:1 student_academics
                'professional',   // relation 1:1 student_professionals
                'documents'       // relation 1:N student_documents
            ])->findOrFail($this->studentId);
        }
    }

    /**
     * Changer l'onglet actif
     *
     * @param string $tab
     */
    public function setTab($tab)
    {
        $allowedTabs = ['general', 'academic', 'professional', 'documents'];
        if (in_array($tab, $allowedTabs)) {
            $this->activeTab = $tab;
        }
    }

    /**
     * Vérifie si les champs sont éditables
     *
     * @return bool
     */
    public function isEditable()
    {
        return in_array($this->mode, ['create', 'edit']);
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
        return view('livewire.admin.student-show', [
            'isEditable' => $this->isEditable(),
        ]);
    }
}
