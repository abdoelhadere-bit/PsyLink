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
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nom complet</label>
                                    <x-input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full" required />
                                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Adresse e-mail</label>
                                    <x-input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full" required />
                                    @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                @if($user->role === 'patient')
                                    <div class="pt-2">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <div class="relative">
                                                <input type="checkbox" name="is_anonymous" {{ $user->is_anonymous ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </div>
                                            <span class="text-sm font-bold text-slate-700 group-hover:text-slate-900 transition-colors">Rester anonyme pour les praticiens</span>
                                        </label>
                                        <p class="mt-2 text-xs text-slate-400">Si activé, votre nom complet ne sera pas visible par les professionnels de santé.</p>
                                    </div>
                                @endif

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-bold bg-slate-900 text-white hover:bg-slate-800 shadow-lg shadow-slate-200 transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </x-card>

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
