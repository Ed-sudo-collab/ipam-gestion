<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\InscriptionValidee;
use App\Mail\InscriptionValideeMail;

class EnvoyerEmailInscription
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
    public function handle(InscriptionValidee $event)
{
    $student = $event->student;

    if ($student->email) {
        Mail::to($student->email)
            ->send(new InscriptionValideeMail($student));
    }
}
}
