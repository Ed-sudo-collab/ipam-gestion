<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TuitionFee;
use App\Models\TuitionInstallment as Installment;

class TuitionInstallment extends Component
{
    public $tuitionFees;
    public $tuition_fee_id;
    public $installmentsForm = [];
    public $editingId = null;

    public function mount()
    {
        $this->tuitionFees = TuitionFee::with('level')->get();
    }

    /* =====================================================
     * REACTIVITY
     * ===================================================== */

    public function updatedTuitionFeeId($value)
    {
        if (!$value) {
            $this->installmentsForm = [];
            $this->editingId = null;
            return;
        }

        $this->loadInstallments($value);
    }

    protected function loadInstallments($tuitionFeeId)
    {
        $installments = Installment::where('tuition_fee_id', $tuitionFeeId)->get();

        if ($installments->isEmpty()) {
            $fee = TuitionFee::find($tuitionFeeId);
            $this->generateInstallments($fee);
        } else {
            $this->installmentsForm = $installments->map(function ($inst) {
                return [
                    'id'       => $inst->id,
                    'label'    => $inst->label,
                    'amount'   => $inst->amount,
                    'due_date' => $inst->due_date->format('Y-m-d'),
                ];
            })->toArray();
        }
    }

    protected function generateInstallments(TuitionFee $fee)
    {
        $this->installmentsForm = [];
        $amountPerInstallment = round($fee->total_amount / $fee->installments, 2);

        for ($i = 1; $i <= $fee->installments; $i++) {
            $this->installmentsForm[] = [
                'label'    => 'Échéance ' . $i,
                'amount'   => $amountPerInstallment,
                'due_date' => null,
            ];
        }
    }

    /* =====================================================
     * VALIDATION
     * ===================================================== */

    protected function rules()
    {
        return [
            'tuition_fee_id' => 'required|exists:tuition_fees,id',
            'installmentsForm' => 'required|array|min:1',
            'installmentsForm.*.label' => 'required|string|max:255',
            'installmentsForm.*.amount' => 'required|numeric|min:0',
            'installmentsForm.*.due_date' => 'required|date',
        ];
    }

    /* =====================================================
     * ACTIONS CRUD
     * ===================================================== */

public function save()
{
    $this->validate();

    // 1️⃣ Récupérer le TuitionFee
    $fee = TuitionFee::findOrFail($this->tuition_fee_id);

    // 2️⃣ Calculer la somme des échéances
    $totalInstallments = collect($this->installmentsForm)
        ->sum(fn ($inst) => (float) $inst['amount']);

    // 3️⃣ Comparer avec le montant total du frais
    if (round($totalInstallments, 2) !== round($fee->total_amount, 2)) {
        $this->addError(
            'installmentsForm',
            "La somme des échéances ({$totalInstallments} FCFA) doit être égale au montant total du frais ({$fee->total_amount} FCFA)."
        );
        return;
    }

    // 4️⃣ Enregistrement (inchangé)
    foreach ($this->installmentsForm as $inst) {
        if (isset($inst['id'])) {
            Installment::find($inst['id'])->update([
                'label'    => $inst['label'],
                'amount'   => $inst['amount'],
                'due_date' => $inst['due_date'],
            ]);
        } else {
            Installment::create([
                'tuition_fee_id' => $this->tuition_fee_id,
                'label'          => $inst['label'],
                'amount'         => $inst['amount'],
                'due_date'       => $inst['due_date'],
            ]);
        }
    }

    session()->flash('success', 'Échéances enregistrées avec succès.');
    $this->loadInstallments($this->tuition_fee_id);
}


public function edit($id)
{
    $inst = Installment::findOrFail($id);
    $this->editingId = $inst->tuition_fee_id; // On garde la référence au TuitionFee

    // Charger toutes les échéances de ce TuitionFee
    $installments = Installment::where('tuition_fee_id', $inst->tuition_fee_id)
        ->orderBy('id', 'asc')
        ->get();

    $this->installmentsForm = $installments->map(function ($item) {
        return [
            'id'       => $item->id,
            'label'    => $item->label,
            'amount'   => $item->amount,
            'due_date' => $item->due_date->format('Y-m-d'),
        ];
    })->toArray();
}


    public function delete($id)
    {
        Installment::findOrFail($id)->delete();
        $this->loadInstallments($this->tuition_fee_id);
        session()->flash('success', 'Échéance supprimée avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.tuition-installment');
    }
}
