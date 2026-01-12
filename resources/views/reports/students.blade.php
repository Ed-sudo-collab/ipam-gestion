<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f0f0f0; }
        .small { font-size: 10px; color: #555; }
    </style>
</head>
<body>

<h1>📄 Liste des étudiants</h1>

<p class="small">
    Date d’export : {{ now()->format('d/m/Y H:i') }}
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Matricule</th>
            <th>Nom & Prénom</th>
            <th>Statut</th>
            <th>Programme</th>
            <th>Niveau</th>
            <th>Année académique</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $index => $student)
            @php
                $enrollment = $student->enrollments->last();
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->matricule }}</td>
                <td>{{ $student->nom }} {{ $student->prenom }}</td>
                <td>{{ $student->statut->libelle ?? '-' }}</td>
                <td>{{ $enrollment->level->program->name ?? '-' }}</td>
                <td>{{ $enrollment->level->name ?? '-' }}</td>
                <td>{{ $enrollment->academicYear->libelle ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center;">Aucun étudiant trouvé</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
