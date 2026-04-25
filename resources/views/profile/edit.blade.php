<x-app-layout>
    <div class="min-h-screen bg-[#FDFDFF] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            
            <header class="mb-12">
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Mon Profil</h1>
                <p class="mt-3 text-lg text-slate-500 font-medium">Gérez vos informations personnelles et la sécurité de votre compte.</p>
            </header>

            <x-flash-messages />

            <div class="space-y-10">
                <!-- Personal Information -->
                <x-card>
                    <div class="flex flex-col md:flex-row gap-10">
                        <div class="md:w-1/3">
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Informations personnelles</h2>
                            <p class="text-sm text-slate-500">Mettez à jour vos informations de base et vos préférences d'affichage.</p>
                        </div>
                        
                        <div class="md:w-2/3">
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Photo de profil -->
                                <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                                    <div class="relative group">
                                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-100 border-2 border-white shadow-sm group-hover:shadow-md transition-all">
                                            @if($user->photo)
                                                <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-2xl">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Photo de profil</label>
                                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="col-span-2">
                                        <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nom complet</label>
                                        <x-input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full" required />
                                        @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Adresse e-mail</label>
                                        <x-input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full" required />
                                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="city" class="block text-sm font-bold text-slate-700 mb-2">Ville</label>
                                        <x-input id="city" name="city" type="text" value="{{ old('city', $user->city) }}" class="w-full" placeholder="Ex: Casablanca" />
                                        @error('city') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">Téléphone</label>
                                        <x-input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="w-full" placeholder="Ex: 06 12 34 56 78" />
                                        @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="birth_date" class="block text-sm font-bold text-slate-700 mb-2">Date de naissance</label>
                                        <x-input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" class="w-full" />
                                        @error('birth_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="gender" class="block text-sm font-bold text-slate-700 mb-2">Sexe</label>
                                        <select name="gender" id="gender" class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all">
                                            <option value="" disabled {{ !old('gender', $user->gender) ? 'selected' : '' }}>Sélectionnez...</option>
                                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Homme</option>
                                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Femme</option>
                                            <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Autre / Préfère ne pas dire</option>
                                        </select>
                                        @error('gender') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    @if($user->role === 'patient')
                                        <div class="col-span-2">
                                            <label for="bio" class="block text-sm font-bold text-slate-700 mb-2">Notes personnelles (facultatif)</label>
                                            <textarea id="bio" name="bio" rows="4" class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-all" placeholder="Quelques mots que vous aimeriez partager avec vos praticiens (historique, contexte...)">{{ old('bio', $user->patient->bio) }}</textarea>
                                            @error('bio') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                    @endif
                                </div>


                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-bold bg-slate-900 text-white hover:bg-slate-800 shadow-lg shadow-slate-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </x-card>

                @if($user->role === 'professional')
                    <!-- Professional Exclusive Settings Shortcut -->
                    <x-card class="border-2 border-blue-100 bg-blue-50/30">
                        <div class="flex flex-col md:flex-row gap-10">
                            <div class="md:w-1/3">
                                <h2 class="text-xl font-bold text-blue-900 mb-2">Paramètres Praticien</h2>
                                <p class="text-sm text-blue-700/70">Gérez votre visibilité, vos tarifs et vos engagements solidaires.</p>
                            </div>
                            
                            <div class="md:w-2/3 flex flex-col gap-4">
                                <div class="bg-white p-4 rounded-xl border border-blue-100 flex items-center justify-between">
                                    <div>
                                        <p class="font-bold text-slate-900">Programme "Praticien Engagé"</p>
                                        <p class="text-xs text-slate-500">Actuellement : 
                                            @if($user->professional->accepts_credits)
                                                <span class="text-emerald-600 font-bold italic">Activé (Vous acceptez les crédits)</span>
                                            @else
                                                <span class="text-slate-400 font-medium">Désactivé (Paiement direct uniquement)</span>
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('professional.profile.edit') }}" class="text-xs font-bold text-blue-600 hover:underline">Modifier</a>
                                </div>

                                <a href="{{ route('professional.profile.edit') }}" class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-4 text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Accéder aux réglages de ma fiche praticien
                                </a>
                            </div>
                        </div>
                    </x-card>
                @endif

                <!-- Security Section -->
                <x-card>
                    <div class="flex flex-col md:flex-row gap-10">
                        <div class="md:w-1/3">
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Sécurité du compte</h2>
                            <p class="text-sm text-slate-500">Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.</p>
                        </div>
                        
                        <div class="md:w-2/3">
                            <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="current_password" class="block text-sm font-bold text-slate-700 mb-2">Mot de passe actuel</label>
                                    <x-input id="current_password" name="current_password" type="password" class="w-full" required />
                                    @error('current_password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Nouveau mot de passe</label>
                                    <x-input id="password" name="password" type="password" class="w-full" required />
                                    @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Confirmer le nouveau mot de passe</label>
                                    <x-input id="password_confirmation" name="password_confirmation" type="password" class="w-full" required />
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-bold bg-white text-slate-900 border border-slate-200 hover:bg-slate-50 shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        Mettre à jour le mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
