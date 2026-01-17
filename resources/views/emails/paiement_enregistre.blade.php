<p>Bonjour {{ $student->prenom }} {{ $student->nom }},</p>

    <p>
        Vous venez d'effectuer un paiement de
        <strong>{{ number_format($payment->total_amount, 0, ',', ' ') }} FCFA</strong>
        pour votre scolarité.
    </p>

    <p>
        💰 <strong>Reste à payer :</strong>
        {{ number_format($resteAPayer, 0, ',', ' ') }} FCFA
    </p>

    <p>
        Merci pour votre confiance.<br>
        <strong>IPAM-BF</strong>
    </p>
