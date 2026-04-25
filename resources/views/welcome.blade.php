<x-app-layout>
    <!-- 1. Hero Section (Medical, Clean, Search-focused) -->
    <div class="bg-blue-50 py-16 lg:py-24 border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Trouvez un professionnel de santé mentale et prenez rendez-vous en ligne
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Consultations en cabinet ou en téléconsultation. Simple, rapide et sécurisé.
                </p>
                
                <!-- Search Bar Card -->
                <form action="{{ route('professionals.index') }}" method="GET" class="bg-white p-3 rounded-2xl shadow-md border border-gray-200 flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" class="block w-full pl-11 pr-3 py-4 border-none rounded-xl text-gray-900 placeholder-gray-500 hover:bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none sm:text-lg transition-colors bg-gray-50/50" placeholder="Nom ou spécialité...">
                    </div>
                    
                    <div class="hidden sm:block w-px h-10 bg-gray-200"></div>
                    
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <input type="text" name="city" class="block w-full pl-11 pr-3 py-4 border-none rounded-xl text-gray-900 placeholder-gray-500 hover:bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none sm:text-lg transition-colors bg-gray-50/50" placeholder="Où (ex: Paris, Lyon)">
                    </div>

                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-xl transition-colors duration-200 shadow-sm">
                        Rechercher
                    </button>
                </form>
                
                <div class="mt-8 flex justify-center gap-4 flex-wrap text-sm text-blue-800 font-medium">
                    <a href="{{ route('professionals.index', ['specialty' => 'psychologue']) }}" class="bg-white border border-blue-200 hover:border-blue-400 hover:bg-blue-50 px-4 py-2 rounded-full transition-colors shadow-sm">Psychologue</a>
                    <a href="{{ route('professionals.index', ['specialty' => 'psychiatre']) }}" class="bg-white border border-blue-200 hover:border-blue-400 hover:bg-blue-50 px-4 py-2 rounded-full transition-colors shadow-sm">Psychiatre</a>
                    <a href="{{ route('professionals.index', ['specialty' => 'therapeute']) }}" class="bg-white border border-blue-200 hover:border-blue-400 hover:bg-blue-50 px-4 py-2 rounded-full transition-colors shadow-sm">Thérapeute TCC</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Section Avantages (Clean & Clinical) -->
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-12">Pourquoi utiliser PsyLink ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <!-- Avantage 1 -->
                <div class="p-6">
                    <div class="w-16 h-16 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sécurité & Confidentialité</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Vos données médicales sont sécurisées et hébergées selon les normes de santé en vigueur.</p>
                </div>
                
                <!-- Avantage 2 -->
                <div class="p-6">
                    <div class="w-16 h-16 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Praticiens vérifiés</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Seuls les diplômes et l'identité des professionnels enregistrés sont certifiés par nos équipes.</p>
                </div>
                
                <!-- Avantage 3 -->
                <div class="p-6">
                    <div class="w-16 h-16 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Consultation immédiate</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Trouvez un praticien disponible rapidement, que ce soit pour une urgence ou un suivi régulier.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Professionnels mis en avant (Sober medical style) -->
    <section class="py-16 bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Praticiens recommandés</h2>
                    <p class="text-gray-600">Réservez une consultation vidéo ou présentielle dès aujourd'hui.</p>
                </div>
                <div>
                    <a href="{{ route('professionals.index') }}" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Voir tous les spécialistes &rarr;</a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendedPros as $pro)
                    <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col h-full hover:border-blue-300 hover:shadow-md transition-all">
                        <div class="flex items-start gap-4 mb-4">
                            <x-pro-avatar :user="$pro->user" size="md" />
                            <div>
                                <h3 class="font-bold text-lg text-blue-900">{{ str_starts_with($pro->user->name, 'Dr') ? $pro->user->name : 'Dr ' . $pro->user->name }}</h3>
                                <p class="text-gray-600 font-medium text-sm">{{ $pro->specialty }}</p>
                                <span class="inline-block mt-1 text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                    {{ $pro->hourly_rate }}€ / heure
                                </span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 mb-6 flex-grow">
                            <div class="flex items-start gap-2 mb-2">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                <span class="line-clamp-2">{{ $pro->bio }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-emerald-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-emerald-700 font-medium">Disponible aujourd'hui</span>
                            </div>
                        </div>
                        <a href="{{ route('professionals.show', $pro->id) }}" class="w-full text-center bg-blue-50 text-blue-700 font-bold py-3 rounded-lg border border-blue-100 hover:bg-blue-100 hover:border-blue-200 transition-colors">
                            Voir le profil
                        </a>
                    </div>
                @endforeach
            </div>
            </div>
            
        </div>
    </section>

    <!-- 4. Section Solidarité (Functional Footer Content) -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Programme de Solidarité PsyLink</h2>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                Parce que la santé mentale doit être accessible à tous, nous proposons un programme solidaire permettant l'accès à des consultations gratuites pour les personnes en situation de précarité, grâce au bénévolat de nos praticiens.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button class="bg-white hover:bg-gray-50 text-gray-800 font-semibold py-3 px-6 rounded-lg border border-gray-300 shadow-sm transition-all focus:ring-2 focus:ring-gray-200">
                    Bénéficier du programme
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg border border-transparent shadow-sm transition-all focus:ring-2 focus:ring-blue-500">
                    Rejoindre en tant que pro
                </button>
            </div>
        </div>
    </section>
</x-app-layout>
