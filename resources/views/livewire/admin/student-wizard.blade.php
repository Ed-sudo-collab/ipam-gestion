<div class="min-h-screen p-6">
    <div class="max-w-5xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="mb-2 text-4xl font-bold text-black">
                Création d'un dossier étudiant
            </h1>
            <p class="text-gray-400">Étape {{ $step }}/4</p>
        </div>

        {{-- Message flash --}}
        @if(session()->has('message'))
            <div class="flex items-center gap-3 p-4 mb-6 text-green-100 bg-green-900 border border-green-700 rounded-lg">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <!-- Barre de progression -->
        <div class="mb-8">
            <div class="flex gap-2">
                @for($i = 1; $i <= 4; $i++)
                    <div class="flex-1">
                        <div class="h-2 rounded-full transition duration-500 {{ $step >= $i ? 'bg-gradient-to-r from-blue-600 to-blue-500' : 'bg-gray-700' }}"></div>
                        <p class="mt-2 text-xs text-center text-gray-400">
                            @if($i == 1) Infos générales
                            @elseif($i == 2) Infos académiques
                            @elseif($i == 3) Infos professionnelles
                            @else Documents
                            @endif
                        </p>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Contenu du formulaire -->
        <div class="p-8 bg-gray-900 border border-gray-800 shadow-2xl rounded-xl">
            <form wire:submit.prevent="save" class="space-y-8">

                {{-- Étape 1 : Infos générales --}}
                @if($step == 1)
                    <div>
                        <h2 class="mb-2 text-2xl font-bold text-white">Informations générales</h2>
                        <p class="mb-6 text-gray-400">Veuillez remplir vos informations personnelles</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Nom</label>
                            <input type="text" wire:model="nom" placeholder="Entrez votre nom"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Prénom</label>
                            <input type="text" wire:model="prenom" placeholder="Entrez votre prénom"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Email</label>
                            <input type="email" wire:model="email" placeholder="Votre adresse email"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Téléphone</label>
                            <input type="tel" wire:model="telephone" placeholder="Votre numéro de téléphone"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Date de naissance</label>
                            <input type="date" wire:model="date_naissance"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Lieu de naissance</label>
                            <input type="text" wire:model="lieu_naissance" placeholder="Lieu de naissance"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Sexe</label>
                            <select wire:model="sexe"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                                <option value="">-- Sélectionner --</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Situation matrimoniale</label>
                            <input type="text" wire:model="situation_matrimoniale" placeholder="Célibataire, Marié(e)..."
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Nombre d'enfants</label>
                            <input type="number" wire:model="nombre_enfants" placeholder="0"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Adresse complète</label>
                        <input type="text" wire:model="adresse" placeholder="Votre adresse complète"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Téléphone parent</label>
                        <input type="tel" wire:model="telephone_parent" placeholder="Numéro du parent"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex justify-end gap-3 pt-6">
                        <button type="button" wire:click="nextStep"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-150">
                            Suivant →
                        </button>
                    </div>
                @endif

                {{-- Étape 2 : Infos académiques --}}
                @if($step == 2)
                    <div>
                        <h2 class="mb-2 text-2xl font-bold text-white">Informations académiques</h2>
                        <p class="mb-6 text-gray-400">Renseignez vos antécédents académiques</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Dernier diplôme</label>
                            <input type="text" wire:model="dernier_diplome" placeholder="Ex: Baccalauréat"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Établissement</label>
                            <input type="text" wire:model="etablissement" placeholder="Nom de l'établissement"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Année d'obtention</label>
                            <input type="number" wire:model="annee_obtention" placeholder="2024"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Mention</label>
                            <input type="text" wire:model="mention" placeholder="Ex: Très bien"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>
                    </div>

                    <!-- Upload des fichiers -->
                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Diplôme (fichier)</label>
                            <div class="p-4 transition border-2 border-gray-700 border-dashed rounded-lg hover:border-blue-500">
                                <input type="file" wire:model="diplome_file" class="w-full text-gray-400">
                            </div>
                            @if(!empty($existingDiplome))
                                <div class="mt-2 text-sm text-gray-400">
                                    Fichier actuel :
                                    <a href="{{ Storage::url($existingDiplome) }}" target="_blank" class="text-blue-400 hover:underline">
                                        {{ basename($existingDiplome) }}
                                    </a>
                                    <button type="button" wire:click="deleteAcademicFile('diplome')" class="ml-2 text-red-400 hover:underline">
                                        Supprimer
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Relevés (fichier)</label>
                            <div class="p-4 transition border-2 border-gray-700 border-dashed rounded-lg hover:border-blue-500">
                                <input type="file" wire:model="releves_file" class="w-full text-gray-400">
                            </div>
                            @if(!empty($existingReleves))
                                <div class="mt-2 text-sm text-gray-400">
                                    Fichier actuel :
                                    <a href="{{ Storage::url($existingReleves) }}" target="_blank" class="text-blue-400 hover:underline">
                                        {{ basename($existingReleves) }}
                                    </a>
                                    <button type="button" wire:click="deleteAcademicFile('releves')" class="ml-2 text-red-400 hover:underline">
                                        Supprimer
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex justify-between gap-3 pt-6">
                        <button type="button" wire:click="prevStep"
                            class="px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                            ← Précédent
                        </button>
                        <button type="button" wire:click="nextStep"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-150">
                            Suivant →
                        </button>
                    </div>
                @endif

                {{-- Étape 3 : Infos professionnelles --}}
                @if($step == 3)
                    <div>
                        <h2 class="mb-2 text-2xl font-bold text-white">Informations professionnelles</h2>
                        <p class="mb-6 text-gray-400">Décrivez votre expérience professionnelle</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Profession actuelle</label>
                            <input type="text" wire:model="profession_actuelle" placeholder="Votre profession"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Employeur</label>
                            <input type="text" wire:model="employeur" placeholder="Nom de l'employeur"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Expérience</label>
                        <textarea wire:model="experience" placeholder="Décrivez votre expérience professionnelle..." rows="5"
                            class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition duration-150 resize-none"></textarea>
                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex justify-between gap-3 pt-6">
                        <button type="button" wire:click="prevStep"
                            class="px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                            ← Précédent
                        </button>
                        <button type="button" wire:click="nextStep"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-150">
                            Suivant →
                        </button>
                    </div>
                @endif

                {{-- Étape 4 : Documents --}}
                @if($step == 4)
                    <div>
                        <h2 class="mb-2 text-2xl font-bold text-white">Documents supplémentaires</h2>
                        <p class="mb-6 text-gray-400">Téléchargez les documents requis</p>
                    </div>

                    <div class="space-y-4">
                        @php
                            $documents_list = [
                                'acte_naissance_file' => 'Acte de naissance ou jugement supplétif',
                                'diplome_doc_file' => 'Diplôme ou attestation de réussite',
                                'lettre_motivation_file' => 'Lettre de motivation',
                                'cv_file' => 'Curriculum Vitae',
                                'photo_file' => 'Photo d\'identité récente',
                                'cni_file' => 'Photocopie de la pièce d\'identité'
                            ];
                        @endphp

                        @foreach($documents_list as $field => $label)
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-300">{{ $label }}</label>
                                <div class="p-4 transition border-2 border-gray-700 border-dashed rounded-lg hover:border-blue-500">
                                    <input type="file" wire:model="{{ $field }}" class="w-full text-gray-400">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Liste des documents existants -->
                    @if(!empty($documents) && $documents->count())
                        <div class="p-4 mt-8 bg-gray-800 border border-gray-700 rounded-lg">
                            <h4 class="mb-3 font-semibold text-white">📄 Documents existants</h4>
                            <ul class="space-y-2">
                                @foreach($documents as $doc)
                                    <li class="flex items-center justify-between text-sm text-gray-300">
                                        <span>
                                            {{ ucfirst(str_replace('_', ' ', $doc->type_document)) }} -
                                            <a href="{{ Storage::url($doc->path) }}" target="_blank" class="text-blue-400 hover:underline">
                                                {{ basename($doc->path) }}
                                            </a>
                                        </span>
                                        <button type="button" wire:click="deleteDocument({{ $doc->id }})"
                                            class="text-red-400 transition hover:text-red-300">
                                            ✕
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Boutons de navigation -->
                    <div class="flex justify-between gap-3 pt-6">
                        <button type="button" wire:click="prevStep"
                            class="px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium rounded-lg transition duration-150">
                            ← Précédent
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition duration-150 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Enregistrer
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
