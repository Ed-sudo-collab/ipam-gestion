<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaiementEnRetardMail extends Mailable
{
    use SerializesModels;

    public $student;
    public $installments;

    public function __construct($student, $installments)
    {
        $this->student = $student;
        $this->installments = $installments;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Alerte retard de paiement');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.paiement_en_retard');
    }
}

