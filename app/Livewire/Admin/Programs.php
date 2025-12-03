<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Program;
use App\Models\Level;

class Programs extends Component
{
    use WithPagination;

    public $name, $description, $level_ids = [], $program_id;
    public $search = '';
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:100|unique:programs,name',
        'level_ids' => 'required|array|min:1',
        'level_ids.*' => 'exists:levels,id',
        'description' => 'nullable|string',
    ];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $programs = Program::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $levels = Level::all();

        return view('livewire.admin.programs', compact('programs', 'levels'));
    }

    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $program = Program::find($id);
            if ($program) {
                $this->program_id = $program->id;
                $this->name = $program->name;
                $this->description = $program->description;
                $this->level_ids = $program->levels->pluck('id')->toArray();
            } else {
                session()->flash('message', 'Programme introuvable.');
                return;
            }
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->level_ids = [];
        $this->program_id = null;
    }

    public function saveProgram()
    {
        $rules = $this->rules;

        if ($this->program_id) {
            $rules['name'] = 'required|string|max:100|unique:programs,name,' . $this->program_id;
        }

        $this->validate($rules);

        $program = Program::updateOrCreate(
            ['id' => $this->program_id],
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        // Attacher les niveaux sélectionnés
        $program->levels()->sync($this->level_ids);

        session()->flash('message', $this->program_id ? 'Programme mis à jour.' : 'Programme créé avec succès.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function deleteProgram($id)
    {
        $program = Program::find($id);
        if ($program) {
            $program->delete();
            session()->flash('message', 'Programme supprimé.');
        } else {
            session()->flash('message', 'Programme introuvable.');
        }
    }
}
