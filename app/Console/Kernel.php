<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Ici tu pourras déclarer tes commandes artisan (ex: SendReminderCommand)
    ];

    protected function schedule(Schedule $schedule)
    {
        // Ici tu planifies les commandes périodiques
        // $schedule->command('tuition:send-reminders')->dailyAt('08:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
