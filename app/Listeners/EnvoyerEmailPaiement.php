<?php

namespace App\Listeners;

use App\Events\PaiementEnregistre;
use App\Mail\PaiementEnregistreMail;
use Illuminate\Support\Facades\Mail;

class EnvoyerEmailPaiement
{
    public function handle(PaiementEnregistre $event)
    {
        if (!$event->student->email) return;

        Mail::to($event->student->email)
            ->send(new PaiementEnregistreMail(
                $event->student,
                $event->payment,
                $event->resteAPayer
            ));
    }
}
