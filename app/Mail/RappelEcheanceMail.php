<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RappelEcheanceMail extends Mailable
{
    public function __construct(
        public $student,
        public $installment,
        public float $remainingAmount
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel d’échéance de scolarité'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rappel_echeance'
        );
    }
}

