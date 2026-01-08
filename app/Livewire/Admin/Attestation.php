<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Enrollment;

class Attestation extends Component
{
    /* =======================
     |   PROPRIÉTÉS
     |======================= */

    public int $enrollmentId;

    public $enrollment;
    public $student;
    public $academicYear;
    public $program;
    public $level;

    /* =======================
     |   INITIALISATION
     |======================= */

    public function mount(int $enrollmentId)
    {
        $this->enrollmentId = $enrollmentId;

        $this->loadAttestationData();
    }

    /* =======================
     |   LOGIQUE
     |======================= */

    private function loadAttestationData(): void
    {
        $this->enrollment = Enrollment::with([
            'student',
            'academicYear',
            'program',
            'level',
        ])->findOrFail($this->enrollmentId);



        $this->student       = $this->enrollment->student;
        $this->academicYear  = $this->enrollment->academicYear;
        $this->program       = $this->enrollment->program;
        $this->level         = $this->enrollment->level;
    }

    /* =======================
     |   RENDER
     |======================= */

    public function render()
    {
        return view('livewire.admin.attestation');
    }
}
