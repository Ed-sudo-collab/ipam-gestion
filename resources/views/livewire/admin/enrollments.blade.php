<div class="card p-4">

    @if (session()->has('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">

        <!-- Étudiant -->
        <div class="mb-3">
            <label>Étudiant</label>
            <select wire:model="student_id" class="form-control">
                <option value="">-- Choisir un étudiant --</option>
                @foreach ($students as $student)
<option value="{{ $student->id }}">
    {{ $student->nom }} {{ $student->prenom }}
</option>

                @endforeach
            </select>
            @error('student_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Année Académique -->
        <div class="mb-3">
            <label>Année académique</label>
            <select wire:model="academic_year_id" class="form-control">
                <option value="">-- Choisir l'année --</option>
                @foreach ($academicYears as $year)
                    <option value="{{ $year->id }}">{{ $year->libelle }}</option>
                @endforeach
            </select>
            @error('academic_year_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Filière -->
        <div class="mb-3">
            <label>Filière (Programme)</label>
            <select wire:model="program_id" class="form-control">
                <option value="">-- Choisir une filière --</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
            @error('program_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Niveau -->
        <div class="mb-3">
            <label>Niveau</label>
            <select wire:model="level_id" class="form-control">
                <option value="">-- Choisir un niveau --</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                @endforeach
            </select>
            @error('level_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Mode d'étude -->
        <div class="mb-3">
            <label>Mode d'étude</label>
            <select wire:model="mode_etude" class="form-control">
                <option value="">-- Choisir --</option>
                <option value="presentiel">Présentiel</option>
                <option value="en_ligne">En ligne</option>
            </select>
            @error('mode_etude') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Bouton -->
        <button class="btn btn-primary w-100">
            Enregistrer l'inscription
        </button>
    </form>

</div>
