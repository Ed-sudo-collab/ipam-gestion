<div class="max-w-5xl p-6 mx-auto bg-white shadow-lg rounded-xl">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Inscription Étudiant - Étape {{ $step }}/4</h2>

    {{-- Message flash --}}
    @if(session()->has('message'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">{{ session('message') }}</div>
    @endif

    {{-- Barre de progression --}}
    <div class="flex mb-6">
        @for($i = 1; $i <= 4; $i++)
            <div class="flex-1 h-2 mx-1 rounded-full {{ $step >= $i ? 'bg-indigo-600' : 'bg-gray-300' }}"></div>
        @endfor
    </div>

    <form wire:submit.prevent="save" class="space-y-8">

        {{-- Étape 1 : Infos générales --}}
        @if($step==1)
            <h3 class="mb-6 text-xl font-semibold text-indigo-700">Informations générales</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <x-input label="Nom" wire:model="nom"/>
                <x-input label="Prénom" wire:model="prenom"/>

                <x-input label="Email" type="email" wire:model="email"/>
                <x-input label="Téléphone" wire:model="telephone"/>

                <x-input label="Date de naissance" type="date" wire:model="date_naissance"/>
                <x-input label="Lieu de naissance" wire:model="lieu_naissance"/>

                <x-select label="Sexe" wire:model="sexe" :options="['M'=>'Masculin','F'=>'Féminin']"/>
                <x-input label="Situation matrimoniale" wire:model="situation_matrimoniale"/>

                <x-input label="Nombre d'enfants" type="number" wire:model="nombre_enfants"/>
            </div>

            {{-- Champs larges --}}
            <div class="mt-6">
                <x-input label="Adresse complète" wire:model="adresse" class="w-full"/>
            </div>
            <div class="mt-6">
                <x-input label="Téléphone parent" wire:model="telephone_parent"/>
            </div>

            <x-wizard-buttons :prev="false"/>
        @endif

        {{-- Étape 2 : Infos académiques --}}
        @if($step==2)
            <h3 class="mb-6 text-xl font-semibold text-indigo-700">Informations académiques</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <x-input label="Dernier diplôme" wire:model="dernier_diplome"/>
                <x-input label="Établissement" wire:model="etablissement"/>

                <x-input label="Année d'obtention" type="number" wire:model="annee_obtention"/>
                <x-input label="Mention" wire:model="mention"/>
            </div>

            {{-- Fichiers en pleine largeur --}}
            <div class="mt-6 space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Diplôme (fichier)</label>
                    <input type="file" wire:model="diplome_file" class="w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Relevés (fichier)</label>
                    <input type="file" wire:model="releves_file" class="w-full px-3 py-2 border rounded">
                </div>
            </div>

            <x-wizard-buttons/>
        @endif

        {{-- Étape 3 : Infos professionnelles --}}
        @if($step==3)
            <h3 class="mb-6 text-xl font-semibold text-indigo-700">Informations professionnelles</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <x-input label="Profession actuelle" wire:model="profession_actuelle"/>
                <x-input label="Employeur" wire:model="employeur"/>
            </div>

            {{-- Expérience en pleine largeur --}}
            <div class="mt-6">
                <label class="block mb-1 font-medium">Expérience</label>
                <textarea wire:model="experience" class="w-full px-3 py-2 border rounded shadow-sm"></textarea>
            </div>

            <x-wizard-buttons/>
        @endif

        {{-- Étape 4 : Documents --}}
        @if($step==4)
            <h3 class="mb-6 text-xl font-semibold text-indigo-700">Documents</h3>

            <input type="file" wire:model="documents" multiple class="w-full px-3 py-2 border rounded">
            <div wire:loading wire:target="documents" class="mt-2 text-sm text-gray-500">Téléchargement en cours...</div>

            {{-- Liste des nouveaux fichiers --}}
            @if($documents)
                <ul class="pl-5 mt-4 space-y-1 list-disc">
                    @foreach($documents as $file)
                        <li>{{ $file->getClientOriginalName() }}</li>
                    @endforeach
                </ul>
            @endif

            {{-- Liste des fichiers existants --}}
            @if($existingDocuments)
                <h4 class="mt-6 font-semibold">Documents existants</h4>
                <ul class="pl-5 mt-2 space-y-1 list-disc">
                    @foreach($existingDocuments as $doc)
                        <li>{{ $doc['filename'] }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="flex justify-between mt-8">
                <button type="button" wire:click="prevStep" class="px-6 py-2 text-white bg-gray-400 rounded">⬅️ Précédent</button>
                <button type="submit" class="px-6 py-2 text-white bg-green-600 rounded">✅ Enregistrer</button>
            </div>
        @endif

    </form>
</div>
