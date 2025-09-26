<div>
    <h3 class="mb-4 text-lg font-semibold">Informations professionnelles</h3>

    @if($student->professional)
        <div class="grid grid-cols-2 gap-4">
            <div><strong>Profession actuelle:</strong> {{ $student->professional->profession }}</div>
            <div><strong>Employeur:</strong> {{ $student->professional->employeur }}</div>
            <div class="col-span-2"><strong>Expérience:</strong> {{ $student->professional->experience }}</div>
        </div>
    @else
        <div class="text-gray-500">Aucune information professionnelle disponible.</div>
    @endif
</div>
