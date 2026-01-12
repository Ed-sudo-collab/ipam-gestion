<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>État des paiements</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>

<h1>💰 État des paiements</h1>

<p>
    Date d’export : {{ now()->format('d/m/Y H:i') }}
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Étudiant</th>
            <th>Matricule</th>
            <th>Programme</th>
            <th>Niveau</th>
            <th>Libellé</th>
            <th>Montant payé</th>
            <th>Date</th>
            <th>Mode</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp

        @foreach($enrollments as $enrollment)
            @foreach($enrollment->tuitionFees as $fee)
                @foreach($fee->installments as $installment)
                    @foreach($installment->paymentAllocations as $allocation)
                        @if($allocation->payment)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $enrollment->student->nom }} {{ $enrollment->student->prenom }}</td>
                                <td>{{ $enrollment->student->matricule }}</td>
                                <td>{{ $enrollment->level->program->name }}</td>
                                <td>{{ $enrollment->level->name }}</td>
                                <td>{{ $installment->label }}</td>
                                <td>{{ number_format($allocation->amount, 0, ',', ' ') }} FCFA</td>
                                <td>{{ \Carbon\Carbon::parse($allocation->payment->payment_date)->format('d/m/Y') }}</td>
                                <td>{{ $allocation->payment->paymentMethod->name ?? '-' }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>
