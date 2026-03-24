<x-app-layout>
    <div class="bg-[var(--color-background-soft)] min-h-screen py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <button onclick="history.back()" class="mb-6 flex items-center text-sm font-medium text-[var(--color-text-gray)] hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour au profil
            </button>

            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-[var(--color-text-dark)] mb-3">Demande de consultation</h1>
                <p class="text-[var(--color-text-gray)]">Renseignez vos préférences pour cette séance avec le Dr. Alice Bernard.</p>
            </div>

            <!-- Header Récap -->
            <x-card class="mb-8 border-l-4 border-l-[var(--color-primary)]">
                <div class="flex items-center gap-4">
                    <img class="w-16 h-16 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Dr+Alice+B&background=e0f2fe&color=0369a1&size=200" alt="Dr">
                    <div>
                        <h2 class="text-lg font-bold text-[var(--color-text-dark)]">Dr. Alice Bernard</h2>
                        <p class="text-sm text-[var(--color-text-primary)]">Psychologue Clinicienne</p>
                    </div>
                    <div class="ml-auto text-right hidden sm:block">
                        <p class="text-sm text-[var(--color-text-gray)]">Tarif</p>
                        <p class="text-xl font-bold">50€ <span class="text-xs font-normal">/ 45 min</span></p>
                    </div>
                </div>
            </x-card>

            <form action="/checkout" method="GET" class="space-y-8">
                
                <!-- 1. Type de consultation -->
                <section>
                    <h3 class="text-lg font-bold text-[var(--color-text-dark)] mb-4 flex items-center gap-2">
                        <span class="bg-blue-100 text-[var(--color-primary)] w-6 h-6 rounded-full inline-flex items-center justify-center text-sm">1</span>
                        Type de consultation
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-2xl border border-gray-200 bg-white p-5 shadow-sm focus:outline-none hover:border-[var(--color-primary)] transition-all">
                            <input type="radio" name="type" value="visio" class="peer sr-only" checked>
                            <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent peer-checked:border-[var(--color-primary)] peer-checked:bg-blue-50/20" aria-hidden="true"></span>
                            <div class="flex flex-1 items-center">
                                <span class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </span>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900">Visioconférence</span>
                                    <span class="mt-1 block text-sm text-gray-500">Échange en vidéo direct</span>
                                </div>
                            </div>
                            <svg class="h-6 w-6 text-[var(--color-primary)] hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>

                        <label class="relative flex cursor-pointer rounded-2xl border border-gray-200 bg-white p-5 shadow-sm focus:outline-none hover:border-[var(--color-primary)] transition-all">
                            <input type="radio" name="type" value="chat" class="peer sr-only">
                            <span class="pointer-events-none absolute -inset-px rounded-2xl border-2 border-transparent peer-checked:border-[var(--color-primary)] peer-checked:bg-blue-50/20" aria-hidden="true"></span>
                            <div class="flex flex-1 items-center">
                                <span class="bg-emerald-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </span>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900">Chat Écrit</span>
                                    <span class="mt-1 block text-sm text-gray-500">Messagerie instantanée</span>
                                </div>
                            </div>
                            <svg class="h-6 w-6 text-[var(--color-primary)] hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>
                    </div>
                </section>

                <!-- 2. Date et Heure -->
                <section>
                    <h3 class="text-lg font-bold text-[var(--color-text-dark)] mb-4 flex items-center gap-2">
                        <span class="bg-blue-100 text-[var(--color-primary)] w-6 h-6 rounded-full inline-flex items-center justify-center text-sm">2</span>
                        Date et créneau horaire
                    </h3>
                    <x-card class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-2">Jour</label>
                                <x-input type="date" class="w-full bg-gray-50/50" value="2026-03-08" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-2">Créneaux disponibles</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" class="py-2 px-3 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed" disabled>09:00</button>
                                    <button type="button" class="py-2 px-3 border border-blue-500 bg-blue-50 rounded-lg text-sm text-blue-700 font-medium font-bold ring-1 ring-blue-500">10:00</button>
                                    <button type="button" class="py-2 px-3 border border-[var(--color-border-light)] hover:border-blue-400 rounded-lg text-sm text-gray-700 transition">11:00</button>
                                    <button type="button" class="py-2 px-3 border border-[var(--color-border-light)] hover:border-blue-400 rounded-lg text-sm text-gray-700 transition">14:00</button>
                                    <button type="button" class="py-2 px-3 border border-[var(--color-border-light)] hover:border-blue-400 rounded-lg text-sm text-gray-700 transition">15:30</button>
                                    <button type="button" class="py-2 px-3 border border-[var(--color-border-light)] hover:border-blue-400 rounded-lg text-sm text-gray-700 transition">17:00</button>
                                </div>
                            </div>
                        </div>
                    </x-card>
                </section>

                <!-- 3. Message -->
                <section>
                    <h3 class="text-lg font-bold text-[var(--color-text-dark)] mb-4 flex items-center gap-2">
                        <span class="bg-blue-100 text-[var(--color-primary)] w-6 h-6 rounded-full inline-flex items-center justify-center text-sm">3</span>
                        Informations complémentaires (Optionnel)
                    </h3>
                    <x-card class="p-6">
                        <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-2">Laissez un court message au praticien pour préparer la séance :</label>
                        <textarea rows="4" class="w-full bg-white border text-[var(--color-text-dark)] border-[var(--color-border-light)] rounded-xl px-4 py-3 focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] focus:ring-1 outline-none transition-shadow shadow-sm" placeholder="Décrivez brièvement le motif de votre consultation..."></textarea>
                    </x-card>
                </section>

                <div class="flex justify-end pt-4 border-t border-[var(--color-border-light)]">
                    <x-button type="submit" variant="primary" class="!px-8 !py-4 text-base shadow-md w-full sm:w-auto">
                        Passer au paiement (50€)
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
