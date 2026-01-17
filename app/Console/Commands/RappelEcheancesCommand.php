<?php

namespace App\Console\Commands;
use App\Models\Student;
use App\Events\RappelEcheance;
use Illuminate\Console\Command;

class RappelEcheancesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rappel-echeances-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
            public function handle()
            {
                Student::with('enrollments')->get()->each(function ($student) {

                    if (!$student->shouldReceiveInstallmentReminder(7)) {
                        return;
                    }

                    $installment = $student->getNextUnpaidInstallment();
                    $remaining   = $installment->getRemainingAmountForStudent($student->id);

                    event(new RappelEcheance(
                        $student,
                        $installment,
                        $remaining
                    ));
                });

                $this->info('Rappels d’échéances envoyés.');
            }
}
