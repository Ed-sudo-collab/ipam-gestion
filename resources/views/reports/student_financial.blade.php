<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Situation financière</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f0f0f0; }
        .right { text-align: right; }
    </style>
</head>
<body>

<h1>📊 Situation financière de l’étudiant</h1>

<p>
    <strong>Matricule :</strong> {{ $student->matricule }}<br>
    <strong>Nom & Prénom :</strong> {{ $student->nom }} {{ $student->prenom }}
</p>

@foreach($summary as $yearId => $sum)
    <h2>Année académique : {{ $sum['label'] }}</h2>

    <table>
        <tr>
            <th>Total frais</th>
            <th>Total payé</th>
            <th>Reste à payer</th>
        </tr>
        <tr>
            <td class="right">{{ number_format($sum['total'], 0, ',', ' ') }} FCFA</td>
            <td class="right">{{ number_format($sum['paid'], 0, ',', ' ') }} FCFA</td>
            <td class="right">{{ number_format($sum['remaining'], 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    <h3>Détail des frais</h3>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Montant</th>
                <th>Payé</th>
                <th>Reste</th>
                <th>Échéance</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feesDetails[$yearId] as $fee)
                <tr>
                    <td>{{ $fee['label'] }}</td>
                    <td class="right">{{ number_format($fee['amount'], 0, ',', ' ') }}</td>
                    <td class="right">{{ number_format($fee['paid'], 0, ',', ' ') }}</td>
                    <td class="right">{{ number_format($fee['remaining'], 0, ',', ' ') }}</td>
                    <td>{{ \Carbon\Carbon::parse($fee['due_date'])->format('d/m/Y') }}</td>
                    <td>{{ $fee['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Historique des paiements</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Libellé</th>
                <th>Montant</th>
                <th>Mode</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paymentsHistory[$yearId] as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment['date'])->format('d/m/Y') }}</td>
                    <td>{{ $payment['label'] }}</td>
                    <td class="right">{{ number_format($payment['amount'], 0, ',', ' ') }}</td>
                    <td>{{ $payment['method'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Aucun paiement enregistré</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endforeach

<p style="margin-top:30px;">
    <strong>Signature Administration :</strong> ________________________
</p>

</body>
</html>
