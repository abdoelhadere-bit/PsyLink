<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Mon Profil Professionnel</h2>
                <p class="mt-2 text-sm text-gray-600">Complétez votre fiche pour être visible et attractif sur l'annuaire PsyLink.</p>
            </div>

            <x-flash-messages />

            <x-card class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('professional.profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Photo de profil -->
                        <div class="flex items-center gap-6 pb-6 border-b border-gray-100">
                            <div class="shrink-0">
                                <x-pro-avatar :user="auth()->user()" size="xl" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Photo de profil</label>
                                <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                <p class="mt-1 text-xs text-gray-400">JPG, PNG ou WEBP. Max 2 Mo.</p>
                                @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Spécialité -->
                        <div>
                            <label for="specialty" class="block text-sm font-bold text-gray-700 mb-2">Spécialité Principale</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                                <select id="specialty" name="specialty" class="pl-10 block w-full border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 transition-colors">
                                    <option value="">Sélectionnez une spécialité...</option>
                                    <option value="Psychologue Clinicien" {{ old('specialty', $professional->specialty) == 'Psychologue Clinicien' ? 'selected' : '' }}>Psychologue Clinicien</option>
                                    <option value="Psychiatre" {{ old('specialty', $professional->specialty) == 'Psychiatre' ? 'selected' : '' }}>Psychiatre</option>
                                    <option value="Thérapeute TCC" {{ old('specialty', $professional->specialty) == 'Thérapeute TCC' ? 'selected' : '' }}>Thérapeute TCC</option>
                                    <option value="Psycho-praticien" {{ old('specialty', $professional->specialty) == 'Psycho-praticien' ? 'selected' : '' }}>Psycho-praticien</option>
                                    <option value="Conseiller d'orientation" {{ old('specialty', $professional->specialty) == 'Conseiller d\'orientation' ? 'selected' : '' }}>Conseiller d'orientation</option>
                                </select>
                            </div>
                            @error('specialty') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-bold text-gray-700 mb-2">Votre Biographie (Description, Approche...)</label>
                            <div class="mt-1">
                                <textarea id="bio" name="bio" rows="6" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-xl p-4 transition-colors placeholder-gray-400" placeholder="Décrivez votre parcours, votre approche thérapeutique et comment vous aidez vos patients...">{{ old('bio', $professional->bio) }}</textarea>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Un bon profil attire plus de patients. Limite : 1000 caractères.</p>
                            @error('bio') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tarif Horaire -->
                        <div class="pb-6 border-b border-gray-100">
                            <label for="hourly_rate" class="block text-sm font-bold text-gray-700 mb-2">Tarif de Consultation (€)</label>
                            <div class="relative rounded-md shadow-sm w-48">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm font-bold">€</span>
                                </div>
                                <input type="number" step="0.5" min="0" max="500" name="hourly_rate" id="hourly_rate" class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-xl py-3 text-lg font-mono font-bold text-gray-900 transition-colors" value="{{ old('hourly_rate', $professional->hourly_rate) }}">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Mettez `0.00` pour offrir vos consultations gratuitement.</p>
                            @error('hourly_rate') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Solidarité Toggle -->
                        <div x-data="{ enabled: {{ $professional->accepts_credits ? 'true' : 'false' }} }">
                            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 flex items-center justify-between group cursor-pointer" @click="enabled = !enabled">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-blue-900">Activer le programme solidaire</h3>
                                        <p class="text-xs text-blue-700 opacity-80">J'accepte d'être réglé avec des "Cœurs Solidaires" pour soutenir les patients en difficulté.</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none ring-offset-2 focus:ring-2 focus:ring-blue-500" :class="enabled ? 'bg-blue-600' : 'bg-gray-200'">
                                    <input type="checkbox" name="accepts_credits" id="accepts_credits" value="1" x-model="enabled" class="sr-only">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="enabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Annuler</a>
                            <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                Sauvegarder le profil
                            </button>
                        </div>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
