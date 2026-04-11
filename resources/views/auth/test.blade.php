<!-- resources/views/auth/register.blade.php -->
<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[var(--color-background-soft)]">
        
        <!-- Step 1: Choix du Profil -->
        <div id="register-step-1" class="w-full max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-[var(--color-text-dark)] mb-3">Rejoignez l'aventure PsyLink</h2>
                <p class="text-[var(--color-text-gray)]">Veuillez sélectionner votre type de profil pour continuer.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Patient -->
                <div onclick="selectRole('patient')" class="cursor-pointer group">
                    <x-card class="h-full border-2 border-transparent hover:border-blue-500 transition-all transform hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Patient</h3>
                        <p class="text-sm text-gray-500">Je cherche un accompagnement ou un soutien solidaire.</p>
                    </x-card>
                </div>

                <!-- Professionnel -->
                <div onclick="selectRole('professional')" class="cursor-pointer group">
                    <x-card class="h-full border-2 border-transparent hover:border-emerald-500 transition-all transform hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Praticien</h3>
                        <p class="text-sm text-gray-500">Je suis certifié et je veux proposer mes services.</p>
                    </x-card>
                </div>

                <!-- Association -->
                <div onclick="selectRole('association')" class="cursor-pointer group">
                    <x-card class="h-full border-2 border-transparent hover:border-purple-500 transition-all transform hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Association</h3>
                        <p class="text-sm text-gray-500">Nous organisons des webinaires et offrons des crédits solidaires.</p>
                    </x-card>
                </div>
            </div>
        </div>

        <!-- Step 2: Formulaire -->
        <div id="register-step-2" class="hidden w-full max-w-xl mx-auto">
            <button onclick="window.location.reload()" class="mb-6 flex items-center text-sm font-medium text-gray-500 hover:text-gray-900">
                ← Retour au choix
            </button>
            
            <x-card class="shadow-2xl">
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="role" id="role-input">
                    
                    <h2 class="text-2xl font-bold text-center" id="form-title">Inscription</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-1">Nom Complet / Nom de l'Asso</label>
                            <x-input type="text" name="name" required class="w-full bg-gray-50" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Email</label>
                            <x-input type="email" name="email" required class="w-full bg-gray-50" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold mb-1">Mot de passe</label>
                                <x-input type="password" name="password" required class="w-full bg-gray-50" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-1">Confirmation</label>
                                <x-input type="password" name="password_confirmation" required class="w-full bg-gray-50" />
                            </div>
                        </div>
                    </div>

                    <x-button type="submit" class="w-full !py-4">Finaliser l'inscription</x-button>
                </form>
            </x-card>
        </div>
    </div>

    <script>
        function selectRole(role) {
            document.getElementById('register-step-1').classList.add('hidden');
            document.getElementById('register-step-2').classList.remove('hidden');
            document.getElementById('role-input').value = role;
            document.getElementById('form-title').innerText = 'Inscription ' + role.charAt(0).toUpperCase() + role.slice(1);
        }
    </script>
</x-app-layout>
