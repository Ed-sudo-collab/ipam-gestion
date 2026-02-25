<x-guest-layout>
    <div class="w-full min-h-screen px-0 py-8 overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900" style="margin: 0; max-width: 100vw;">

        <!-- Éléments de décoration floue -->
        <div class="absolute top-0 left-0 bg-blue-500 rounded-full w-96 h-96 mix-blend-multiply filter blur-3xl opacity-10 -z-10"></div>
        <div class="absolute bottom-0 right-0 bg-indigo-500 rounded-full w-96 h-96 mix-blend-multiply filter blur-3xl opacity-10 -z-10"></div>
        <div class="absolute bg-purple-500 rounded-full top-1/2 left-1/2 w-96 h-96 mix-blend-multiply filter blur-3xl opacity-10 -z-10"></div>

        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md">

                <!-- En-tête avec logo -->
                <div class="mb-8 text-center">
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 rounded-full opacity-75 bg-gradient-to-r from-blue-600 to-indigo-600 blur"></div>
                                <x-slot name="logo">
                                    <img
                                        src="{{ asset('images/logo.png') }}"
                                        alt="Logo Institut"
                                        class="relative object-contain w-20 h-20 p-2 rounded-full bg-slate-900"
                                    >
                                </x-slot>

                        </div>
                    </div>
                    <h1 class="mb-2 text-3xl font-bold text-white">Portail Académique</h1>
                    <p class="text-sm text-slate-400">Gestion des Inscriptions et Frais de Scolarité</p>
                </div>

                <!-- Carte de connexion -->
                <div class="overflow-hidden border shadow-2xl backdrop-blur-md bg-slate-800/50 border-slate-700/50 rounded-2xl">

                    <!-- Corps du formulaire -->
                    <div class="px-8 py-10">

                        <!-- Messages d'erreur -->
                        @if ($errors->any())
                            <div class="p-4 mb-6 border rounded-lg bg-red-500/10 border-red-500/30">
                                <div class="flex items-center mb-3">
                                    <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium text-red-400">Erreur de connexion</span>
                                </div>
                                <ul class="space-y-1 text-xs text-red-400 ml-7">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Message de succès -->
                        @session('status')
                            <div class="flex items-center p-4 mb-6 border rounded-lg bg-green-500/10 border-green-500/30">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-green-400">{{ $value }}</span>
                            </div>
                        @endsession

                        <!-- Formulaire -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <!-- Champ Email -->
                            <div>
                                <label for="email" class="block mb-2 text-sm font-semibold text-slate-200">
                                    Adresse Email
                                </label>
                                <div class="relative">
                                    <svg class="absolute w-5 h-5 -translate-y-1/2 left-4 top-1/2 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="votre@email.com"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        class="w-full py-3 pl-12 pr-4 text-white transition border rounded-lg bg-slate-700/50 border-slate-600/50 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    />
                                </div>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Champ Mot de passe -->
                            <div>
                                <label for="password" class="block mb-2 text-sm font-semibold text-slate-200">
                                    Mot de Passe
                                </label>
                                <div class="relative">
                                    <svg class="absolute w-5 h-5 -translate-y-1/2 left-4 top-1/2 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="••••••••"
                                        required
                                        autocomplete="current-password"
                                        class="w-full py-3 pl-12 pr-4 text-white transition border rounded-lg bg-slate-700/50 border-slate-600/50 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    />
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Se souvenir de moi -->
                            <div class="flex items-center pt-2">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="w-4 h-4 text-blue-600 rounded bg-slate-700 border-slate-600 focus:ring-blue-500"
                                />
                                <label for="remember_me" class="ml-2 text-sm text-slate-400">
                                    Se souvenir de moi
                                </label>
                            </div>

                            <!-- Bouton de connexion -->
                            <button type="submit" class="w-full py-3 mt-8 font-semibold text-white transition duration-200 transform rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:shadow-lg hover:shadow-blue-500/50 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-slate-900">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Connexion
                                </div>
                            </button>
                        </form>

                        <!-- Lien mot de passe oublié -->
                        @if (Route::has('password.request'))
                            <div class="pt-6 text-center border-t border-slate-700/50">
                                <a class="text-sm font-medium text-blue-400 transition hover:text-blue-300" href="{{ route('password.request') }}">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Pied de page -->
                    <div class="px-8 py-4 text-center border-t bg-slate-900/50 border-slate-700/50">
                        <p class="text-xs text-slate-500">
                            © {{ date('Y') }} Institut Supérieur. Tous droits réservés.
                        </p>
                    </div>
                </div>

                <!-- Support -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-400">
                        Besoin d'aide ? <a href="#" class="font-semibold text-blue-400 transition hover:text-blue-300">Contactez l'administration</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
