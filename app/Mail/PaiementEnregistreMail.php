<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PaiementEnregistreMail extends Mailable
{
    public function __construct(
        public $student,
        public $payment,
        public $resteAPayer
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Paiement de scolarité enregistré'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.paiement_enregistre'
        );
    }
}
