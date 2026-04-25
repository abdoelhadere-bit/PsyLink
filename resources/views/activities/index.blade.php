<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- En-tête -->
            <div class="mb-8 bg-blue-600 rounded-xl px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Missions bénévoles</h1>
                <p class="mt-1 text-sm text-blue-100">
                    Participez à des actions de terrain avec nos associations partenaires et gagnez des crédits pour vos consultations.
                </p>
            </div>

            <!-- Formulaire de Recherche & Filtre -->
            <div class="bg-white p-4 rounded-xl shadow-sm mb-6 border border-gray-100">
                <form action="{{ route('activities.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="hidden" name="filter" value="{{ $filter ?? 'all' }}">
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-3 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher une mission..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="city" class="w-full py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                            <option value="">Toutes les villes</option>
                            @foreach(['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kénitra', 'Tétouan', 'Salé', 'El Jadida'] as $opt)
                                <option value="{{ $opt }}" {{ ($city ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-sm text-sm">
                        Filtrer
                    </button>
                    @if($search || $city)
                        <a href="{{ route('activities.index') }}" class="text-xs text-gray-400 underline flex items-center justify-center">Effacer</a>
                    @endif
                </form>
            </div>

            <!-- Messages Flash -->
            <x-flash-messages />

            <!-- Filtre par statut -->
            @auth
            @if(auth()->user()->role === 'patient')
            <div class="flex flex-wrap gap-2 mb-6">
                @php
                    $filters = [
                        'all'      => ['label' => 'Toutes les missions', 'color' => 'gray'],
                        'accepted' => ['label' => 'Confirmées',          'color' => 'green'],
                        'pending'  => ['label' => 'En attente',          'color' => 'yellow'],
                        'available'=> ['label' => 'Disponibles',         'color' => 'blue'],
                        'attended' => ['label' => 'Réalisées',           'color' => 'violet'],
                    ];
                    $currentFilter = $filter ?? 'all';
                @endphp
                @foreach($filters as $key => $f)
                    @php
                        $isActive = $currentFilter === $key || ($key === 'all' && !$currentFilter);
                        $activeClass = match($f['color']) {
                            'green'  => 'bg-green-600 text-white border-green-600',
                            'yellow' => 'bg-amber-500 text-white border-amber-500',
                            'blue'   => 'bg-blue-600 text-white border-blue-600',
                            'violet' => 'bg-violet-600 text-white border-violet-600',
                            default  => 'bg-gray-700 text-white border-gray-700',
                        };
                        $inactiveClass = 'bg-white text-gray-600 border-gray-200 hover:border-gray-300';
                    @endphp
                    <a href="{{ route('activities.index', ['filter' => $key]) }}"
                       class="px-4 py-1.5 text-sm font-medium rounded-full border transition-colors {{ $isActive ? $activeClass : $inactiveClass }}">
                        {{ $f['label'] }}
                    </a>
                @endforeach
            </div>
            @endif
            @endauth

            <!-- Liste des missions -->
            @if(isset($activities) && count($activities) > 0)
                <div class="space-y-4">
                    @foreach($activities as $activity)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <div class="flex">
                            {{-- Barre colorée gauche selon le type --}}
                            @php
                                $borderColor = match(true) {
                                    str_contains($activity->type ?? '', 'ecole') => 'bg-amber-400',
                                    str_contains($activity->type ?? '', 'orphelinat') => 'bg-rose-400',
                                    str_contains($activity->type ?? '', 'repos') => 'bg-violet-400',
                                    str_contains($activity->type ?? '', 'handicap') => 'bg-teal-400',
                                    str_contains($activity->type ?? '', 'social') => 'bg-emerald-400',
                                    default => 'bg-blue-400',
                                };
                            @endphp
                            <div class="w-1.5 {{ $borderColor }} shrink-0"></div>

                            <div class="flex-1 p-5">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                            <div class="flex-1">
                                {{-- Association --}}
                                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">
                                    {{ $activity->association->name ?? '' }}
                                </p>

                                {{-- Titre --}}
                                <h2 class="text-base font-semibold text-gray-900 mb-2">{{ $activity->title }}</h2>

                                {{-- Description --}}
                                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                    {{ $activity->description }}
                                </p>

                                {{-- Méta : date, ville, places --}}
                                <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $activity->scheduled_at ? \Carbon\Carbon::parse($activity->scheduled_at)->translatedFormat('d F Y à H:i') : 'Date à confirmer' }}
                                    </span>
                                    @if($activity->city)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $activity->city }}
                                    </span>
                                    @endif
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="font-bold underline">{{ $activity->available_places }}</span> / {{ $activity->max_participants }} places disponibles
                                    </span>
                                </div>
                            </div>

                            {{-- Colonne droite : récompense + bouton --}}
                            <div class="flex flex-col items-end gap-3 shrink-0">
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">Récompense</p>
                                    <p class="text-sm font-semibold text-emerald-600">
                                        +{{ $activity->free_sessions_earned }} séance{{ $activity->free_sessions_earned > 1 ? 's' : '' }} gratuite{{ $activity->free_sessions_earned > 1 ? 's' : '' }}
                                    </p>
                                </div>

                                @if(isset($userParticipations[$activity->id]))
                                    @if($userParticipations[$activity->id] === 'pending')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded border border-gray-200 bg-gray-50 text-xs text-gray-500 font-medium">
                                            En attente de validation
                                        </span>
                                    @elseif($userParticipations[$activity->id] === 'accepted')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded border border-green-200 bg-green-50 text-xs text-green-700 font-medium">
                                            Inscription confirmée
                                        </span>
                                    @elseif($userParticipations[$activity->id] === 'attended')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded border border-blue-200 bg-blue-50 text-xs text-blue-700 font-medium">
                                            Mission realisee
                                        </span>
                                    @elseif($userParticipations[$activity->id] === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded border border-red-200 bg-red-50 text-xs text-red-600 font-medium">
                                            Refusee
                                        </span>
                                    @endif
                                @else
                                    <form action="{{ route('activities.join', $activity) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors">
                                            Participer
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg p-10 text-center">
                    <p class="text-sm text-gray-500">Aucune mission disponible pour le moment.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
