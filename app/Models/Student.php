<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TuitionInstallment; // <--- ici
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'telephone',
        'situation_matrimoniale',
        'nombre_enfants',
        'adresse',
        'email',
        'telephone_parent',
        'statut_id'
    ];

    /**
     * Générer un matricule unique pour un étudiant
     */
    public static function generateMatricule()
    {
        $last = self::latest('id')->first();
        $nextId = $last ? $last->id + 1 : 1;

        return 'ETU-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }



    /**
     * Met à jour le statut financier de l'étudiant
     */


    public function updateFinancialStatus(): void
    {
        // Récupérer toutes les échéances liées à l'étudiant dont la date est <= aujourd'hui
        $dueInstallments = TuitionInstallment::whereHas('tuitionFee.enrollments', function ($q) {
                $q->where('student_id', $this->id);
            })
            ->whereDate('due_date', '<=', Carbon::today())
            ->get();

        // Vérifier s'il existe AU MOINS une échéance non totalement payée par cet étudiant
        $hasUnpaidDueInstallment = $dueInstallments->contains(function ($installment) {
            $paidAmount = $installment->paymentAllocations()
                ->whereHas('payment', function ($q) {
                    $q->where('student_id', $this->id);
                })
                ->sum('amount');

            return $paidAmount < $installment->amount;
        });

        // Mise à jour du statut financier
        $this->statut_id = $hasUnpaidDueInstallment
            ? 5 // En retard de paiement
            : 4; // À jour

        $this->save();
    }



    // Relations

    // Un étudiant appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statut()
    {
        return $this->belongsTo(StudentStatut::class, 'statut_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }







public function enroll($academicYear, $program, $level)
{
    return Enrollment::create([
        'student_id' => $this->id,
        'academic_year_id' => $academicYear->id,
        'program_id' => $program->id,
        'level_id' => $level->id,
        'enrollment_date' => now(),
        'status' => 'PENDING',
    ]);
}



    public function academic()
    {
        return $this->hasOne(StudentAcademic::class);
    }

    public function professional()
    {
        return $this->hasOne(StudentProfessional::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }









    public function getTotalDebt(): float
    {
        /**
         * 🔹 Total des échéances de scolarité de l’étudiant
         */
        $totalDue = TuitionInstallment::whereHas(
            'tuitionFee.enrollments',
            fn ($q) => $q->where('student_id', $this->id)
        )->sum('amount');

        /**
         * 🔹 Total payé par l’étudiant (réellement affecté aux échéances)
         */
        $totalPaid = TuitionInstallment::whereHas(
            'tuitionFee.enrollments',
            fn ($q) => $q->where('student_id', $this->id)
        )->withSum([
            'paymentAllocations as paid_amount' => function ($q) {
                $q->whereHas('payment', fn ($p) =>
                    $p->where('student_id', $this->id)
                );
            }
        ], 'amount')->get()->sum('paid_amount');

        /**
         * 🔹 Reste à payer
         */
        return max(0, $totalDue - $totalPaid);
    }






    public function getNextUnpaidInstallment(): ?TuitionInstallment
    {
        return TuitionInstallment::whereHas(
            'tuitionFee.enrollments',
            fn ($q) => $q->where('student_id', $this->id)
        )
        ->whereDate('due_date', '>=', Carbon::today())
        ->get()
        ->filter(fn ($inst) =>
            $inst->getRemainingAmountForStudent($this->id) > 0
        )
        ->sortBy('due_date')
        ->first();
    }





    public function shouldReceiveInstallmentReminder(int $daysBefore = 7): bool
    {
        $installment = $this->getNextUnpaidInstallment();

        if (!$installment) {
            return false;
        }

        $today = now()->startOfDay();
        $limit = now()->startOfDay()->addDays($daysBefore);

        // Convertir due_date en Carbon pour être sûr
        $dueDate = Carbon::parse($installment->due_date)->startOfDay();

        return $dueDate->between($today, $limit);
    }







    public function getOverdueInstallments(): \Illuminate\Support\Collection
    {
        // On récupère toutes les échéances non soldées dont la date est dépassée
        return TuitionInstallment::whereHas('tuitionFee.enrollments', function ($q) {
            $q->where('student_id', $this->id);
        })
        ->get()
        ->filter(fn ($inst) => $inst->getRemainingAmountForStudent($this->id) > 0
                            && $inst->due_date->lt(Carbon::today()));
    }


    public function shouldReceiveOverdueNotification(): bool
    {
        return $this->getOverdueInstallments()->isNotEmpty();
    }





}
