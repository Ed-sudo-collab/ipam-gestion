<div>
    <h3 class="mb-4 text-lg font-semibold">Informations générales</h3>
    <div class="grid grid-cols-2 gap-4">
        <div><strong>Matricule:</strong> {{ $student->matricule }}</div>
        <div><strong>Nom:</strong> {{ $student->nom }}</div>
        <div><strong>Prénom:</strong> {{ $student->prenom }}</div>
        <div><strong>Email:</strong> {{ $student->email }}</div>
        <div><strong>Téléphone:</strong> {{ $student->telephone }}</div>
        <div><strong>Date de naissance:</strong> {{ $student->date_naissance ?? '-' }}</div>
        <div><strong>Lieu de naissance:</strong> {{ $student->lieu_naissance ?? '-' }}</div>
        <div><strong>Sexe:</strong> {{ $student->sexe ?? '-' }}</div>
        <div><strong>Situation matrimoniale:</strong> {{ $student->situation_matrimoniale ?? '-' }}</div>
        <div><strong>Nombre d'enfants:</strong> {{ $student->nombre_enfants ?? '-' }}</div>
    </div>
</div>
