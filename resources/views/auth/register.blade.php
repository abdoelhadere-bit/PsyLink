<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[var(--color-background-soft)]">


        <div id="register-step-2" class="hidden w-full max-w-xl mx-auto">
            <button onclick="document.getElementById('register-step-1').classList.remove('hidden'); document.getElementById('register-step-2').classList.add('hidden');" class="mb-6 flex items-center text-sm font-medium text-[var(--color-text-gray)] hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour au choix du profil
            </button>
            
            <x-card class="shadow-xl">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-[var(--color-text-dark)] mb-2" id="form-title">Création de compte</h2>
                    <p class="text-sm text-[var(--color-text-gray)]" id="form-subtitle">Remplissez vos informations pour commencer.</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" id="role-input" value="patient">
                    @error('role')
                        <div class="p-3 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm mb-4">{{ $message }}</div>
                    @enderror
                    
                    <!-- Champs Communs -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Nom complet / Pseudo</label>
                            <x-input type="text" name="name" required class="w-full bg-gray-50/50" placeholder="Jean Dupont" />
                            @error('name')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Adresse Email</label>
                            <x-input type="email" name="email" required class="w-full bg-gray-50/50" placeholder="vous@exemple.com" />
                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Mot de passe</label>
                            <x-input type="password" name="password" required class="w-full bg-gray-50/50" placeholder="••••••••" />
                            @error('password')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Confirmer mot de passe</label>
                            <x-input type="password" name="password_confirmation" required class="w-full bg-gray-50/50" placeholder="••••••••" />
                            @error('password_confirmation')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Champs Spécifiques Professionnel (cachés par défaut) -->
                    <div id="pro-fields" class="hidden space-y-5 pt-4 border-t border-[var(--color-border-light)] mt-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="col-span-1 sm:col-span-2">
                                <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Spécialité Principale</label>
                                <select class="w-full bg-gray-50/50 border text-[var(--color-text-dark)] border-[var(--color-border-light)] rounded-xl px-4 py-3 focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] focus:ring-1 outline-none transition-shadow">
                                    <option value="">Sélectionnez une spécialité...</option>
                                    <option value="psychologue">Psychologue Clinicien</option>
                                    <option value="psychiatre">Psychiatre</option>
                                    <option value="therapeute">Thérapeute TCC</option>
                                </select>
                            </div>
                            <div class="col-span-1 sm:col-span-2">
                                <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Justificatif de certification (PDF/Image)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:border-blue-400 transition-colors bg-white">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="relative cursor-pointer bg-white rounded-md font-medium text-[var(--color-primary)] hover:text-blue-500 focus-within:outline-none">
                                                <span>Télécharger un fichier</span>
                                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, PDF jusqu'à 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CGU & Anonymat -->
                    <div class="space-y-4 pt-4 border-t border-[var(--color-border-light)]">
                        <div id="patient-options" class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="anonymity" name="anonymity" type="checkbox" class="h-4 w-4 text-[var(--color-primary)] rounded border-gray-300">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="anonymity" class="font-medium text-[var(--color-text-dark)]">Je souhaite rester anonyme</label>
                                <p class="text-[var(--color-text-gray)]">Mon vrai nom ne sera jamais affiché aux praticiens.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-[var(--color-primary)] rounded border-gray-300">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-[var(--color-text-gray)]">
                                    J'accepte les <a href="{{ route('about') }}" class="font-medium text-[var(--color-primary)] hover:text-blue-500">Conditions Générales d'Utilisation</a> et la <a href="{{ route('about') }}" class="font-medium text-[var(--color-primary)] hover:text-blue-500">Politique de Confidentialité</a>.
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <x-button type="submit" variant="primary" class="w-full !py-4 text-base shadow-md">
                            Finaliser l'inscription
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
        
        <!-- Vanilla JS for handling steps (fallback if Alpine not present) -->
        <div id="register-step-1" class="w-full max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-[var(--color-text-dark)] mb-3">Rejoignez l'aventure PsyLink</h2>
                <p class="text-[var(--color-text-gray)]">Veuillez sélectionner le type de compte que vous souhaitez créer.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Rôle Patient -->
                <div onclick="selectRole('patient')" class="cursor-pointer group">
                    <x-card class="h-full border-2 border-transparent hover:border-[var(--color-primary)] transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-8 h-8 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[var(--color-text-dark)] mb-2">Compte Utilisateur</h3>
                        <p class="text-sm text-[var(--color-text-gray)] leading-relaxed">Je souhaite trouver un professionnel pour m'accompagner, lancer une consultation ou bénéficier du programme solidaire.</p>
                        
                        <div class="mt-6 flex items-center text-sm font-medium text-[var(--color-primary)] opacity-0 group-hover:opacity-100 transition-opacity">
                            Sélectionner <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </x-card>
                </div>

                <!-- Rôle Professionnel -->
                <div onclick="selectRole('professional')" class="cursor-pointer group">
                    <x-card class="h-full border-2 border-transparent hover:border-[var(--color-secondary)] transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6 group-hover:bg-emerald-100 transition-colors">
                            <svg class="w-8 h-8 text-[var(--color-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[var(--color-text-dark)] mb-2">Compte Professionnel</h3>
                        <p class="text-sm text-[var(--color-text-gray)] leading-relaxed">Je suis un professionnel de la santé mentale certifié et je souhaite proposer mes services sur la plateforme.</p>
                        
                        <div class="mt-6 flex items-center text-sm font-medium text-[var(--color-secondary)] opacity-0 group-hover:opacity-100 transition-opacity">
                            Sélectionner <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </x-card>
                </div>

                <!-- Association -->
                <div onclick="selectRole('association')" class="cursor-pointer group">
                    <x-card class="h-full border-2 border-transparent hover:border-purple-500 transition-all transform hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Association</h3>
                        <p class="text-sm text-gray-500">Nous organisons des missions solidaires et offrons des séances aux bénévoles.</p>
                    </x-card>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <p class="text-sm text-[var(--color-text-gray)]">Déjà inscrit ? <a href="/login" class="font-semibold text-[var(--color-primary)] hover:text-blue-500 transition-colors">Connectez-vous</a></p>
            </div>
        </div>

    </div>

    <script>
        // Clean Vanilla JS logic to swap between steps
        function selectRole(role) {
            document.getElementById('register-step-1').classList.add('hidden');
            document.getElementById('register-step-2').classList.remove('hidden');
            document.getElementById('role-input').value = role;

            if (role === 'professional') {
                document.getElementById('form-title').innerText = 'Inscription Professionnel';
                document.getElementById('form-subtitle').innerText = 'Rejoignez notre réseau de praticiens validés.';
                document.getElementById('pro-fields').classList.remove('hidden');
                document.getElementById('patient-options').classList.add('hidden');
            } else if (role === 'patient') {
                document.getElementById('form-title').innerText = 'Inscription Patient';
                document.getElementById('form-subtitle').innerText = 'Quelques informations pour sécuriser votre accès.';
                document.getElementById('pro-fields').classList.add('hidden');
                document.getElementById('patient-options').classList.remove('hidden');
            } else if (role === 'association') {
                document.getElementById('form-title').innerText = 'Inscription Association';
                document.getElementById('form-subtitle').innerText = 'Quelques informations pour sécuriser votre accès.';
                document.getElementById('pro-fields').classList.add('hidden');
                document.getElementById('patient-options').classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
