<x-app-layout>
    <!-- 1. Hero Section -->
    <section class="relative overflow-hidden pt-12 pb-24 lg:pt-20 lg:pb-32">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-blue-200 to-emerald-200 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                <div class="lg:col-span-6 text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-[var(--color-text-dark)] mb-6">
                        Soutien psychologique à distance, <span class="text-[var(--color-primary)]">en toute confiance</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-[var(--color-text-gray)] mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Consultez des professionnels certifiés par chat ou visioconférence, en toute confidentialité, avec paiement sécurisé ou accès solidaire.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <x-button variant="primary" class="w-full sm:w-auto !px-8 !py-4 text-base">Trouver un professionnel</x-button>
                        <x-button variant="secondary" class="w-full sm:w-auto !px-8 !py-4 text-base">Créer un compte</x-button>
                    </div>
                    
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-4 text-sm text-[var(--color-text-gray)]">
                        <div class="flex -space-x-2">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Marie+D&background=random" alt=""/>
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Lucas+M&background=random" alt=""/>
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Sophie+L&background=random" alt=""/>
                        </div>
                        <p>Déjà <span class="font-semibold text-[var(--color-text-dark)]">250+</span> personnes accompagnées</p>
                    </div>
                </div>
                
                <div class="hidden lg:block lg:col-span-6 relative mt-16 lg:mt-0">
                    <div class="relative w-full h-[500px] rounded-[2rem] bg-gradient-to-br from-blue-50 to-emerald-50 overflow-hidden shadow-sm border border-[var(--color-border-light)] p-8 flex flex-col justify-center items-center">
                        <!-- Abstract Mockup -->
                        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 transform -rotate-2 hover:rotate-0 transition-transform duration-500">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex-shrink-0"></div>
                                <div class="flex-1">
                                    <div class="h-4 bg-gray-200 rounded w-24 mb-2"></div>
                                    <div class="h-3 bg-gray-100 rounded w-32"></div>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-3 bg-gray-100 rounded w-full"></div>
                                <div class="h-3 bg-gray-100 rounded w-5/6"></div>
                            </div>
                        </div>
                        
                        <div class="w-full max-w-sm bg-white rounded-2xl shadow-sm border border-gray-100 p-4 transform translate-x-8 opacity-90">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div class="h-10 bg-gray-50 rounded-xl flex-1 px-3 py-2 flex items-center">
                                    <div class="h-2 bg-gray-200 rounded w-20"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Section Avantages -->
    <section class="py-16 bg-white border-y border-[var(--color-border-light)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Avantage 1 -->
                <x-card class="bg-gray-50/50 hover:bg-white transition-colors">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Confidentialité garantie</h3>
                    <p class="text-[var(--color-text-gray)] text-sm leading-relaxed">Vos données et échanges sont entièrement chiffrés et protégés. Anonymat possible.</p>
                </x-card>
                
                <!-- Avantage 2 -->
                <x-card class="bg-gray-50/50 hover:bg-white transition-colors">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Professionnels validés</h3>
                    <p class="text-[var(--color-text-gray)] text-sm leading-relaxed">Chaque praticien est vérifié manuellement par notre équipe (diplômes, expérience).</p>
                </x-card>
                
                <!-- Avantage 3 -->
                <x-card class="bg-gray-50/50 hover:bg-white transition-colors">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Consultation facile</h3>
                    <p class="text-[var(--color-text-gray)] text-sm leading-relaxed">Échangez via messagerie sécurisée ou lancez une visioconférence en un clic.</p>
                </x-card>
                
                <!-- Avantage 4 -->
                <x-card class="bg-gray-50/50 hover:bg-white transition-colors">
                    <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Accès solidaire</h3>
                    <p class="text-[var(--color-text-gray)] text-sm leading-relaxed">Un programme de bénévolat permet l'accès à des séances gratuites pour les plus démunis.</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- 3. Section "Comment ça marche" -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Un accompagnement en 4 étapes</h2>
                <p class="text-lg text-[var(--color-text-gray)] max-w-2xl mx-auto">Parcours simplifié pour vous concentrer sur l'essentiel : votre bien-être.</p>
            </div>
            
            <div class="relative">
                <!-- Ligne de connexion (Desktop) -->
                <div class="hidden md:block absolute top-12 left-0 right-0 h-0.5 bg-gray-200" aria-hidden="true"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                    <!-- Étape 1 -->
                    <div class="relative text-center">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-blue-100 flex items-center justify-center shadow-sm relative z-10 mb-6">
                            <span class="text-2xl font-bold text-[var(--color-primary)]">1</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Trouver</h3>
                        <p class="text-[var(--color-text-gray)] text-sm">Sélectionnez le professionnel qui vous correspond selon vos critères.</p>
                    </div>
                    
                    <!-- Étape 2 -->
                    <div class="relative text-center">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-emerald-100 flex items-center justify-center shadow-sm relative z-10 mb-6">
                            <span class="text-2xl font-bold text-[var(--color-secondary)]">2</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Réserver</h3>
                        <p class="text-[var(--color-text-gray)] text-sm">Choisissez un créneau disponible et le type de consultation idéal (Chat ou Visio).</p>
                    </div>
                    
                    <!-- Étape 3 -->
                    <div class="relative text-center">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-blue-100 flex items-center justify-center shadow-sm relative z-10 mb-6">
                            <span class="text-2xl font-bold text-[var(--color-primary)]">3</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Régler</h3>
                        <p class="text-[var(--color-text-gray)] text-sm">Paiement sécurisé ou accès gratuit via notre programme validé de bénévolat.</p>
                    </div>
                    
                    <!-- Étape 4 -->
                    <div class="relative text-center">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-emerald-100 flex items-center justify-center shadow-sm relative z-10 mb-6">
                            <span class="text-2xl font-bold text-[var(--color-secondary)]">4</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Consulter</h3>
                        <p class="text-[var(--color-text-gray)] text-sm">Connectez-vous à l'heure prévue dans votre espace patient dédié et sécurisé.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Professionnels mis en avant -->
    <section class="py-24 bg-gray-50 border-t border-[var(--color-border-light)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold mb-4">Professionnels de santé</h2>
                    <p class="text-lg text-[var(--color-text-gray)]">Découvrez quelques-uns de nos praticiens certifiés.</p>
                </div>
                <div class="hidden sm:block">
                    <a href="#" class="text-[var(--color-primary)] font-medium hover:text-blue-700 transition-colors">Voir tous les profils &rarr;</a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Pro 1 -->
                <x-card class="hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4 mb-6">
                        <img class="w-16 h-16 rounded-2xl object-cover ring-2 ring-gray-100" src="https://ui-avatars.com/api/?name=Dr+Alice+B&background=e0f2fe&color=0369a1" alt="Dr Alice B."/>
                        <div>
                            <h3 class="font-semibold text-lg text-[var(--color-text-dark)]">Dr. Alice Bernard</h3>
                            <p class="text-sm text-[var(--color-text-gray)] mb-1">Psychologue Clinicienne</p>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-sm font-medium">4.9</span>
                                <span class="text-xs text-gray-400">(42 avis)</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Anxiété</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Dépression</span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-[var(--color-border-light)]">
                        <div class="text-[var(--color-text-dark)] font-semibold">50€ <span class="text-xs text-gray-500 font-normal">/ séance</span></div>
                        <x-button variant="secondary" class="!px-4 !py-2 text-sm !rounded-lg">Voir le profil</x-button>
                    </div>
                </x-card>
                
                <!-- Pro 2 -->
                <x-card class="hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4 mb-6">
                        <img class="w-16 h-16 rounded-2xl object-cover ring-2 ring-gray-100" src="https://ui-avatars.com/api/?name=Dr+Marc+T&background=d1fae5&color=047857" alt="Dr Marc T."/>
                        <div>
                            <h3 class="font-semibold text-lg text-[var(--color-text-dark)]">Dr. Marc Thomas</h3>
                            <p class="text-sm text-[var(--color-text-gray)] mb-1">Psychiatre</p>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-sm font-medium">4.8</span>
                                <span class="text-xs text-gray-400">(28 avis)</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Burn-out</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Traumatismes</span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-[var(--color-border-light)]">
                        <div class="text-[var(--color-text-dark)] font-semibold">65€ <span class="text-xs text-gray-500 font-normal">/ séance</span></div>
                        <x-button variant="secondary" class="!px-4 !py-2 text-sm !rounded-lg">Voir le profil</x-button>
                    </div>
                </x-card>
                
                <!-- Pro 3 -->
                <x-card class="hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4 mb-6">
                        <img class="w-16 h-16 rounded-2xl object-cover ring-2 ring-gray-100" src="https://ui-avatars.com/api/?name=Dr+Chloe+M&background=fce7f3&color=be185d" alt="Dr Chloé M."/>
                        <div>
                            <h3 class="font-semibold text-lg text-[var(--color-text-dark)]">Chloé Martin</h3>
                            <p class="text-sm text-[var(--color-text-gray)] mb-1">Thérapeute TCC</p>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-sm font-medium">5.0</span>
                                <span class="text-xs text-gray-400">(61 avis)</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Gestion du stress</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Sommeil</span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-[var(--color-border-light)]">
                        <div class="text-[var(--color-text-dark)] font-semibold">45€ <span class="text-xs text-gray-500 font-normal">/ séance</span></div>
                        <x-button variant="secondary" class="!px-4 !py-2 text-sm !rounded-lg">Voir le profil</x-button>
                    </div>
                </x-card>
            </div>
            
            <div class="mt-8 text-center sm:hidden">
                <a href="#" class="text-[var(--color-primary)] font-medium hover:text-blue-700 transition-colors">Voir tous les profils &rarr;</a>
            </div>
        </div>
    </section>

    <!-- 5. CTA Final -->
    <section class="py-20 bg-white relative overflow-hidden text-center">
        <div class="absolute inset-0 bg-[var(--color-primary)] opacity-5"></div>
        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-6">Ne restez pas seul avec vos émotions</h2>
            <p class="text-lg text-[var(--color-text-gray)] mb-8">
                Que ce soit pour une séance ponctuelle ou un suivi régulier, trouvez l'écoute bienveillante dont vous avez besoin dès aujourd'hui.
            </p>
            <x-button variant="primary" class="!px-10 !py-4 text-lg shadow-md hover:shadow-lg transition-shadow">Commencer maintenant</x-button>
        </div>
    </section>
</x-app-layout>
