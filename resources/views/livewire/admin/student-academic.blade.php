<div>
    <h3 class="mb-4 text-lg font-semibold">Informations académiques</h3>

    @if($student->academic)
        <div class="grid grid-cols-2 gap-4">
            <div><strong>Dernier diplôme:</strong> {{ $student->academic->dernier_diplome }}</div>
            <div><strong>Établissement:</strong> {{ $student->academic->etablissement }}</div>
            <div><strong>Année d'obtention:</strong> {{ $student->academic->annee_obtention }}</div>
            <div><strong>Mention:</strong> {{ $student->academic->mention }}</div>
        </div>
    @else
        <div class="text-gray-500">Aucune information académique disponible.</div>
    @endif
</div>
