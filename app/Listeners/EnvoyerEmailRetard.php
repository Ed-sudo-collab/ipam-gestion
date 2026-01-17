<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PaiementEnRetard;
use App\Mail\PaiementEnRetardMail;
use Illuminate\Support\Facades\Mail;


class EnvoyerEmailRetard
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaiementEnRetard $event)
        {
            $student = $event->student;

            if ($student->email && $event->installments->isNotEmpty()) {
                Mail::to($student->email)
                    ->send(new PaiementEnRetardMail($student, $event->installments));
            }
        }
}
