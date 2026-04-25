<x-app-layout>
    <div class="bg-[var(--color-background-soft)] min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Recherche -->
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-bold text-[var(--color-text-dark)] mb-2">Trouvez le bon professionnel</h1>
                <p class="text-[var(--color-text-gray)]">Filtrez par spécialité, tarif et disponibilité pour un accompagnement sur mesure.</p>
            </div>

            <form action="{{ route('professionals.index') }}" method="GET" class="flex flex-col lg:flex-row gap-8">
                
                <aside class="w-full lg:w-1/4">
                    <x-card class="p-6">
                        <div class="mb-6">
                            <label class="block text-sm font-bold mb-2">Rechercher un nom</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ex: Jean" class="w-full rounded-xl border-gray-200" onchange="this.form.submit()">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold mb-2">Ville</label>
                            <input type="text" name="city" value="{{ request('city') }}" placeholder="Ex: Casablanca" class="w-full rounded-xl border-gray-200" onchange="this.form.submit()">
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold mb-2">Spécialité</h3>
                            <select name="specialty" class="w-full rounded-xl border-gray-200" onchange="this.form.submit()">
                                <option value="">Toutes</option>
                                <option value="Psychologue Clinicien" {{ request('specialty') == 'Psychologue Clinicien' ? 'selected' : '' }}>Psychologue</option>
                                <option value="Psychiatre" {{ request('specialty') == 'Psychiatre' ? 'selected' : '' }}>Psychiatre</option>
                                <option value="Thérapeute TCC" {{ request('specialty') == 'Thérapeute TCC' ? 'selected' : '' }}>TCC</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold mb-2">Prix Max ({{ request('price_max', 150) }}€)</h3>
                            <input type="range" name="price_max" min="0" max="200" step="5" value="{{ request('price_max', 150) }}" 
                                   class="w-full" oninput="this.nextElementSibling.innerText = this.value + '€'" onchange="this.form.submit()">
                        </div>

                        <a href="{{ route('professionals.index') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                            Réinitialiser
                        </a>
                    </x-card>
                </aside>


                <!-- Liste des Professionnels -->
                <main class="w-full lg:w-3/4">
                    <!-- Top Bar Résultats -->
                    <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-[var(--color-border-light)] mb-6">
                        <p class="text-sm font-medium text-[var(--color-text-dark)] mb-4 sm:mb-0">
                            {{ $professionals->count() }} professionnels trouvés
                        </p>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-[var(--color-text-gray)]">Trier par :</span>
                            <select name="sort" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] pl-3 pr-8 py-1.5 cursor-pointer">
                                <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommandé</option>
                                <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Note décroissante</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Tarif moins cher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grille -->
                    <div class="space-y-6">
                        <!-- Pro 1 -->
                         @foreach($professionals as $professional)
                        <x-card class="flex flex-col sm:flex-row gap-6 hover:border-[var(--color-primary)] hover:shadow-md transition-all">
                            <div class="flex-shrink-0 relative">
                                <x-pro-avatar :user="$professional->user" size="lg" />
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-2">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-xl font-bold text-[var(--color-text-dark)]">{{ str_starts_with($professional->user->name, 'Dr.') ? '' : 'Dr. ' }}{{$professional->user->name}}</h3>
                                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="Profil vérifié"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-[var(--color-primary)]">{{$professional->specialty}}</p>
                                    </div>
                                    <div class="flex flex-col sm:items-end">
                                        <div class="flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2 py-1 rounded-md mb-1">
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span class="text-sm font-bold">{{ $professional->reviews_avg_rating ? number_format($professional->reviews_avg_rating, 1) : 'Nouv.' }}</span>
                                            <span class="text-xs opacity-75">({{ $professional->reviews->count() }} avis)</span>
                                        </div>
                                        <p class="text-lg font-bold">{{$professional->hourly_rate}}€ <span class="text-xs font-normal text-gray-500">/ 1 heure</span></p>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-[var(--color-text-gray)] line-clamp-2 md:line-clamp-3 mb-4">
                                    {{$professional->bio}}
                                </p>
                                
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                    <div class="flex flex-wrap gap-2">
                                        @if($professional->user->city)
                                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium border border-blue-100 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $professional->user->city }}
                                            </span>
                                        @endif
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">Anxiété</span>
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">Dépression</span>
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-medium border border-emerald-100 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Dispo. ajd
                                        </span>
                                    </div>
                                    <a href="/professionals/{{$professional->id}}" class="w-full sm:w-auto text-center inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium bg-[var(--color-primary)] text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors">
                                        Voir le profil
                                    </a>
                                </div>
                            </div>
                        </x-card>
                        @endforeach
                    </div>
                </main>
            </form>
        </div>
    </div>
</x-app-layout>
