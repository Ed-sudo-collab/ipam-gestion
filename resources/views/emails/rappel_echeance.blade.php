<p>Bonjour {{ $student->prenom }} {{ $student->nom }},</p>

<p>
Votre prochaine échéance de scolarité est prévue le
<strong>{{ $installment->due_date->format('d/m/Y') }}</strong>.
</p>

<p>
Montant restant à payer pour cette échéance :
<strong>{{ number_format($remainingAmount, 0, ',', ' ') }} FCFA</strong>
</p>

<p>Merci de régulariser votre situation avant la date limite.</p>

<p><strong>IPAM-BF</strong></p>




