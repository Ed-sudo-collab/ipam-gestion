<h2>Bonjour {{ $student->nom }} {{ $student->prenom }},</h2>

<p>Vous êtes en retard de paiement pour les échéances suivantes :</p>

<ul>
@foreach ($installments as $inst)
    <li>{{ $inst->label }} - Montant restant : {{ number_format($inst->getRemainingAmountForStudent($student->id), 2) }} FCFA (échéance : {{ $inst->due_date->format('d/m/Y') }})</li>
@endforeach
</ul>

<p>Merci de régulariser votre situation dès que possible.</p>

<p>Cordialement,<br>IPAM-BF</p>
