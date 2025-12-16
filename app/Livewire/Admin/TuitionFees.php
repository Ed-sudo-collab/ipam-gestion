<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TuitionFee;
use App\Models\Level;

class TuitionFees extends Component
{
    /* ==========================
     * DATA
     * ========================== */
    public $tuitionFees;
    public $levels;

    /* ==========================
     * FORM FIELDS
     * ========================== */
    public $tuitionFeeId;
    public $level_id;
    public $total_amount;
    public $installments;

    public $isEdit = false;

    /* ==========================
     * LIFECYCLE
     * ========================== */
    public function mount()
    {
        $this->levels = Level::all();
        $this->loadTuitionFees();
    }

    public function loadTuitionFees()
    {
        $this->tuitionFees = TuitionFee::with('level')->get();
    }

    /* ==========================
     * VALIDATION
     * ========================== */
    protected function rules()
    {
        return [
            'level_id'     => 'required|exists:levels,id',
            'total_amount' => 'required|numeric|min:0',
            'installments' => 'required|integer|min:1',
        ];
    }

    /* ==========================
     * ACTIONS
     * ========================== */
    public function store()
    {
        $this->validate();

        TuitionFee::create([
            'level_id'     => $this->level_id,
            'total_amount' => $this->total_amount,
            'installments' => $this->installments,
        ]);

        session()->flash('success', 'Frais de scolarité créé avec succès');

        $this->resetForm();
        $this->loadTuitionFees();
    }

    public function edit($id)
    {
        $fee = TuitionFee::findOrFail($id);

        $this->tuitionFeeId = $fee->id;
        $this->level_id     = $fee->level_id;
        $this->total_amount = $fee->total_amount;
        $this->installments = $fee->installments;

        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $fee = TuitionFee::findOrFail($this->tuitionFeeId);

        $fee->update([
            'level_id'     => $this->level_id,
            'total_amount' => $this->total_amount,
            'installments' => $this->installments,
        ]);

        session()->flash('success', 'Frais de scolarité modifié avec succès');

        $this->resetForm();
        $this->loadTuitionFees();
    }

    public function delete($id)
    {
        TuitionFee::findOrFail($id)->delete();

        session()->flash('success', 'Frais supprimé');

        $this->loadTuitionFees();
    }

    public function resetForm()
    {
        $this->reset([
            'tuitionFeeId',
            'level_id',
            'total_amount',
            'installments',
            'isEdit',
        ]);
    }

    /* ==========================
     * RENDER
     * ========================== */
    public function render()
    {
        return view('livewire.admin.tuition-fees');
    }
}
