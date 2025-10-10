<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\StudentDocument;

class StudentDocuments extends Component
{
    use WithFileUploads;

    public $student;
    public $documents;
    public $newDocument;
    public $type_document;

    // Types autorisés pour la validation
    protected $allowedTypes = [
        'acte_naissance',
        'diplome',
        'lettre_motivation',
        'cv',
        'photo',
        'cni',
    ];

    public function mount($student)
    {
        $this->student = $student;
        $this->loadDocuments();
    }

    public function loadDocuments()
    {
        $this->documents = $this->student->documents;
    }

    public function upload()
    {
        $this->validate([
            'newDocument' => 'required|file|max:5120', // 5MB max
            'type_document' => 'required|in:' . implode(',', $this->allowedTypes),
        ]);

        $filePath = $this->newDocument->store('student_documents');

        $this->student->documents()->create([
            'type_document' => $this->type_document,
            'path' => $filePath,
        ]);

        // Réinitialisation des champs
        $this->newDocument = null;
        $this->type_document = null;

        $this->loadDocuments();

        session()->flash('message', 'Document ajouté ✅');
    }

    public function delete($id)
    {
        $doc = StudentDocument::findOrFail($id);
        \Storage::delete($doc->path);
        $doc->delete();

        $this->loadDocuments();
        session()->flash('message', 'Document supprimé 🗑️');
    }

    public function render()
    {
        return view('livewire.admin.student-documents');
    }
}
