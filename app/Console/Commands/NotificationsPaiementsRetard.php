<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Events\PaiementEnRetard;

class NotificationsPaiementsRetard extends Command
{
    protected $signature = 'app:notifications-paiements-retard';
    protected $description = 'Envoi des notifications pour les paiements en retard';

    public function handle()
    {
        Student::all()->each(function ($student) {
            if ($student->shouldReceiveOverdueNotification()) {
                event(new PaiementEnRetard($student));
            }
        });

        $this->info('Notifications de retard envoyées.');
    }
}
