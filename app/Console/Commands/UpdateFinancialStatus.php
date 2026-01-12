<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class UpdateFinancialStatus extends Command
{
    protected $signature = 'students:update-financial-status';
    protected $description = 'Met à jour le statut financier de tous les étudiants';

    public function handle()
    {
        Student::all()->each->updateFinancialStatus();
        $this->info('Statuts financiers mis à jour pour tous les étudiants.');
    }
}
