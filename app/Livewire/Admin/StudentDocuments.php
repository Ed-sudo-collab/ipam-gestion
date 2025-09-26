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
    public $newDocument, $type;

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
            'newDocument' => 'required|file|max:5120',
            'type' => 'required|string|max:100',
        ]);

        $filePath = $this->newDocument->store('student_documents');

        $this->student->documents()->create([
            'type' => $this->type,
            'file_path' => $filePath,
        ]);

        $this->newDocument = null;
        $this->type = null;
        $this->loadDocuments();

        session()->flash('message', 'Document ajouté ✅');
    }

    public function delete($id)
    {
        $doc = StudentDocument::findOrFail($id);
        \Storage::delete($doc->file_path);
        $doc->delete();

        $this->loadDocuments();
        session()->flash('message', 'Document supprimé 🗑️');
    }

    public function render()
    {
        return view('livewire.admin.student-documents');
    }
}
