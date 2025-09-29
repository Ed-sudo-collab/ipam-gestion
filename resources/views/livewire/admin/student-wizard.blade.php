<div class="max-w-4xl p-6 mx-auto bg-white shadow-lg rounded-xl">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Inscription Étudiant - Étape {{ $step }}/4</h2>

    {{-- Messages flash --}}
    @if (session()->has('message'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Progress bar --}}
    <div class="flex mb-6">
        @for ($i = 1; $i <= 4; $i++)
            <div class="flex-1 h-2 mx-1 rounded-full {{ $step >= $i ? 'bg-indigo-600' : 'bg-gray-300' }}"></div>
        @endfor
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Étape 1 - Informations générales --}}
        @if ($step == 1)
            <h3 class="mb-4 text-xl font-semibold text-gray-700">Informations générales</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block mb-1 text-gray-600">Nom</label>
                    <input type="text" wire:model="nom" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('nom') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Prénom</label>
                    <input type="text" wire:model="prenom" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('prenom') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Email</label>
                    <input type="email" wire:model="email" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Téléphone</label>
                    <input type="text" wire:model="telephone" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                    @error('telephone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Date de naissance</label>
                    <input type="date" wire:model="date_naissance" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Lieu de naissance</label>
                    <input type="text" wire:model="lieu_naissance" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div class="col-span-2">
                    <label class="block mb-1 text-gray-600">Sexe</label>
                    <select wire:model="sexe" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                        <option value="">Sélectionner</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <span></span>
                <button type="button" wire:click="nextStep" class="px-6 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Suivant </button>
            </div>
        @endif

        {{-- Étape 2 - Informations académiques --}}
        @if ($step == 2)
            <h3 class="mb-4 text-xl font-semibold text-gray-700">Informations académiques</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block mb-1 text-gray-600">Dernier diplôme</label>
                    <input type="text" wire:model="dernier_diplome" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Établissement</label>
                    <input type="text" wire:model="etablissement" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Année d'obtention</label>
                    <input type="number" wire:model="annee_obtention" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Mention</label>
                    <input type="text" wire:model="mention" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button type="button" wire:click="prevStep" class="px-6 py-2 text-white bg-gray-400 rounded hover:bg-gray-500">⬅️ Précédent</button>
                <button type="button" wire:click="nextStep" class="px-6 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Suivant ➡️</button>
            </div>
        @endif

        {{-- Étape 3 - Informations professionnelles --}}
        @if ($step == 3)
            <h3 class="mb-4 text-xl font-semibold text-gray-700">Informations professionnelles</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block mb-1 text-gray-600">Profession actuelle</label>
                    <input type="text" wire:model="profession_actuelle" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label class="block mb-1 text-gray-600">Employeur</label>
                    <input type="text" wire:model="employeur" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div class="col-span-2">
                    <label class="block mb-1 text-gray-600">Expérience</label>
                    <textarea wire:model="experience" class="w-full px-3 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-200"></textarea>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button type="button" wire:click="prevStep" class="px-6 py-2 text-white bg-gray-400 rounded hover:bg-gray-500">⬅️ Précédent</button>
                <button type="button" wire:click="nextStep" class="px-6 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Suivant ➡️</button>
            </div>
        @endif

        {{-- Étape 4 - Documents --}}
        @if ($step == 4)
            <h3 class="mb-4 text-xl font-semibold text-gray-700">Documents</h3>
            <div class="space-y-4">
                <input type="file" wire:model="documents" multiple class="w-full">
                <div wire:loading wire:target="documents" class="text-indigo-600">Téléchargement en cours...</div>

                @if ($documents)
                    <ul class="text-gray-700 list-disc list-inside">
                        @foreach ($documents as $file)
                            <li>{{ $file->getClientOriginalName() }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="flex justify-between mt-6">
                <button type="button" wire:click="prevStep" class="px-6 py-2 text-white bg-gray-400 rounded hover:bg-gray-500">⬅️ Précédent</button>
                <button type="submit" class="px-6 py-2 text-white bg-green-600 rounded hover:bg-green-700">✅ Enregistrer</button>
            </div>
        @endif
    </form>
</div>
