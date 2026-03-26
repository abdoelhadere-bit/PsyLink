<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-[var(--color-background-soft)] py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
        <div class="max-w-xl w-full">
            <div class="mb-8 text-center text-gray-800">
                <a href="{{ route('professionals.show', $professional->id) }}" class="inline-flex items-center text-sm font-medium text-[var(--color-primary)] hover:text-blue-500 mb-6 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour au profil
                </a>
                <h1 class="text-3xl font-extrabold tracking-tight text-[var(--color-text-dark)] mb-2">Prendre Rendez-vous</h1>
                <p class="text-md text-[var(--color-text-gray)]">Remplissez ce formulaire pour envoyer une demande de consultation.</p>
            </div>

            <x-card class="shadow-2xl bg-white/95 backdrop-blur-xl border border-white/50 relative overflow-hidden">
                <!-- Decorative Blur -->
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                
                <div class="p-6 sm:p-8 relative z-10">
                    <!-- Résumé du Pro -->
                    <div class="flex items-center gap-4 p-5 mb-8 bg-blue-50/50 rounded-2xl border border-blue-100 shadow-inner">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[var(--color-primary)] to-blue-400 flex items-center justify-center text-white font-bold text-2xl shadow-sm">
                            {{ substr($professional->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[var(--color-text-dark)]">Dr. {{ $professional->user->name }}</h3>
                            <p class="text-sm border bg-[var(--color-primary)]/10 border-[var(--color-primary)]/20 text-[var(--color-primary)] px-2 py-0.5 rounded-md inline-block mt-1">{{ $professional->specialty }}</p>
                        </div>
                        <div class="ml-auto text-right">
                            <span class="block text-2xl font-black text-[var(--color-text-dark)] leading-none">{{ $professional->hourly_rate }}€</span>
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wider">/ 45 min</span>
                        </div>
                    </div>

                    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="professional_id" value="{{ $professional->id }}">
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Type de consultation -->
                            <div>
                                <label class="block text-sm font-bold text-[var(--color-text-dark)] mb-3">Format de la séance</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label class="group relative flex cursor-pointer rounded-2xl border-2 border-gray-100 bg-white p-4 shadow-sm focus:outline-none hover:border-[var(--color-primary)] hover:bg-blue-50/20 transition-all duration-300">
                                        <input type="radio" name="type" value="video" class="peer sr-only" checked>
                                        <div class="flex flex-col">
                                            <span class="block text-base font-bold text-[var(--color-text-dark)] mb-1 flex items-center gap-2">
                                                <div class="p-1.5 bg-blue-100 rounded-lg text-blue-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg></div>
                                                Téléconsultation
                                            </span>
                                            <span class="block text-xs text-gray-500 leading-relaxed">Entretien vidéo sécurisé via notre plateforme.</span>
                                        </div>
                                        <div class="absolute -inset-px rounded-2xl border-2 border-transparent peer-checked:border-[var(--color-primary)] peer-checked:bg-[var(--color-primary)]/5 pointer-events-none transition-all duration-300" aria-hidden="true"></div>
                                    </label>
                                    
                                    <label class="group relative flex cursor-pointer rounded-2xl border-2 border-gray-100 bg-white p-4 shadow-sm focus:outline-none hover:border-[var(--color-primary)] hover:bg-blue-50/20 transition-all duration-300">
                                        <input type="radio" name="type" value="chat" class="peer sr-only">
                                        <div class="flex flex-col">
                                            <span class="block text-base font-bold text-[var(--color-text-dark)] mb-1 flex items-center gap-2">
                                                <div class="p-1.5 bg-green-100 rounded-lg text-green-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg></div>
                                                Chat écrit
                                            </span>
                                            <span class="block text-xs text-gray-500 leading-relaxed">Échange par messages instantanés en direct.</span>
                                        </div>
                                        <div class="absolute -inset-px rounded-2xl border-2 border-transparent peer-checked:border-[var(--color-primary)] peer-checked:bg-[var(--color-primary)]/5 pointer-events-none transition-all duration-300" aria-hidden="true"></div>
                                    </label>
                                </div>
                                @error('type')
                                    <p class="text-sm text-red-500 mt-2 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date et Heure -->
                            <div>
                                <label for="scheduled_at" class="block text-sm font-bold text-[var(--color-text-dark)] mb-3">Choix du créneau</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input type="datetime-local" 
                                           name="scheduled_at" 
                                           id="scheduled_at" 
                                           required 
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] block pl-10 p-4 text-base transition-colors" 
                                           min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}">
                                </div>
                                <p class="text-xs text-gray-500 mt-2 italic">Toute demande doit être faite au moins 1 heure à l'avance.</p>
                                @error('scheduled_at')
                                    <p class="text-sm text-red-500 mt-2 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 mt-8">
                            <x-button type="submit" variant="primary" class="w-full justify-center !py-4 text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                Envoyer la demande de séance
                            </x-button>
                            <p class="text-center text-xs text-gray-500 mt-4 flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                Paiement sécurisé requis après acceptation du praticien.
                            </p>
                        </div>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
