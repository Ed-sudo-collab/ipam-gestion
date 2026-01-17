<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\RappelEcheance;
use App\Mail\RappelEcheanceMail;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelEcheance
{
    public function handle(RappelEcheance $event)
    {
        if (!$event->student->email) return;

        Mail::to($event->student->email)
            ->send(new RappelEcheanceMail(
                $event->student,
                $event->installment,
                $event->remainingAmount
            ));
    }
}
