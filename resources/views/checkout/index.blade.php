<x-app-layout>
    <div class="bg-[var(--color-background-soft)] min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <button onclick="history.back()" class="mb-6 flex items-center text-sm font-medium text-[var(--color-text-gray)] hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à la demande
            </button>

            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-[var(--color-text-dark)] mb-3">Paiement Sécurisé</h1>
                <p class="text-[var(--color-text-gray)] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    Connexion cryptée 256-bit SSL
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <!-- Résumé de la commande (Gauche) -->
                <div class="w-full lg:w-5/12 order-2 lg:order-1">
                    <x-card class="bg-gray-50 border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold text-[var(--color-text-dark)] mb-6 border-b border-gray-200 pb-4">Résumé de la séance</h2>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <img class="w-16 h-16 rounded-2xl object-cover shadow-sm ring-2 ring-white" src="https://ui-avatars.com/api/?name=Dr+Alice+B&background=e0f2fe&color=0369a1&size=200" alt="Dr Alice B.">
                            <div>
                                <h3 class="font-bold text-[var(--color-text-dark)]">Dr. Alice Bernard</h3>
                                <p class="text-xs text-[var(--color-text-gray)]">Psychologue Clinicienne</p>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--color-text-gray)]">Date</span>
                                <span class="font-medium text-[var(--color-text-dark)]">Dimanche 8 Mars 2026</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--color-text-gray)]">Heure</span>
                                <span class="font-medium text-[var(--color-text-dark)]">10:00 - 10:45 (45 min)</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--color-text-gray)]">Format</span>
                                <span class="font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Visioconférence
                                </span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200 space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--color-text-gray)]">Prix de la séance</span>
                                <span>50.00 €</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[var(--color-text-gray)]">Frais de service (inclus)</span>
                                <span>0.00 €</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t-2 border-dashed border-gray-200">
                            <span class="text-lg font-bold text-[var(--color-text-dark)]">Total à payer</span>
                            <span class="text-2xl font-black text-[var(--color-text-dark)]">50.00 <span class="text-xl">€</span></span>
                        </div>

                        <!-- Accès Solidaire Mockup -->
                        <div class="mt-6 p-4 rounded-xl border border-orange-200 bg-orange-50 hidden" id="solidaire-block">
                            <div class="flex gap-3 items-start">
                                <svg class="w-5 h-5 text-orange-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-sm font-bold text-orange-800">Prise en charge solidaire activée</h4>
                                    <p class="text-xs text-orange-700 mt-1">Le montant de cette séance est couvert à 100% par le programme de bénévolat. Aucun prélèvement ne sera effectué.</p>
                                </div>
                            </div>
                        </div>

                    </x-card>
                </div>

                <!-- Formulaire de Paiement (Droite) -->
                <div class="w-full lg:w-7/12 order-1 lg:order-2">
                    <x-card class="shadow-xl ring-1 ring-gray-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="p-3 bg-blue-50 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold text-[var(--color-text-dark)]">Informations de facturation</h2>
                        </div>

                        <form action="/" method="GET" class="space-y-6">
                            
                            <!-- Mode de paiement (Mockup) -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-2">Méthode de paiement</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="card" class="peer sr-only" checked>
                                        <div class="rounded-xl border border-gray-200 bg-white p-4 peer-checked:border-[var(--color-primary)] peer-checked:ring-1 peer-checked:ring-[var(--color-primary)] transition-all flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-gray-500 peer-checked:text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            <span class="text-sm font-medium">Carte Bancaire</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="solidaire" class="peer sr-only" onchange="document.getElementById('solidaire-block').classList.toggle('hidden'); document.getElementById('card-details').classList.toggle('hidden'); document.getElementById('pay-btn').innerText = this.checked ? 'Confirmer la séance (Gratuit)' : 'Payer 50.00 €'">
                                        <div class="rounded-xl border border-gray-200 bg-white p-4 peer-checked:border-orange-500 peer-checked:ring-1 peer-checked:ring-orange-500 transition-all flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-gray-500 peer-checked:text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            <span class="text-sm font-medium">Accès Bénévole</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Détails Carte -->
                            <div id="card-details" class="space-y-5 bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Nom sur la carte</label>
                                    <x-input type="text" placeholder="JEAN DUPONT" class="w-full bg-white font-mono uppercase text-sm" />
                                </div>
                                
                                <div class="relative">
                                    <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Numéro de carte</label>
                                    <div class="relative">
                                        <x-input type="text" placeholder="0000 0000 0000 0000" class="w-full bg-white pl-10 font-mono text-sm" />
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">Date d'expiration</label>
                                        <x-input type="text" placeholder="MM/AA" class="w-full bg-white font-mono text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">CVC</label>
                                        <div class="relative">
                                            <x-input type="text" placeholder="123" class="w-full bg-white font-mono text-sm" />
                                            <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 text-center flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><path d="M0 0h24v24H0z" fill="none"/><path d="M11 7h2v2h-2zm0 4h2v6h-2z"/></svg>
                                Vos données de paiement ne sont jamais stockées sur nos serveurs.
                            </p>

                            <x-button type="submit" variant="primary" class="w-full !px-8 !py-4 text-lg font-bold shadow-lg shadow-blue-500/30 transform transition-transform active:scale-[0.98] bg-green-500 hover:bg-green-600 focus:ring-green-500" id="pay-btn">
                                Payer 50.00 €
                            </x-button>
                        </form>
                    </x-card>
                    
                    <div class="mt-6 flex justify-center gap-4 opacity-50 grayscale">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Visa.svg/1200px-Visa.svg.png" class="h-6" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1200px-Mastercard-logo.svg.png" class="h-6" alt="Mastercard">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/2560px-PayPal.svg.png" class="h-6" alt="Paypal">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
