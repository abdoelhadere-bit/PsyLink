<x-app-layout>
    <div class="bg-[var(--color-background-soft)] min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Recherche -->
            <div class="mb-10 text-center md:text-left flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-blue-600 to-emerald-500 rounded-3xl p-8 shadow-lg">
                <div class="text-white max-w-2xl">
                    <div class="inline-flex items-center gap-2 bg-white/20 rounded-full px-3 py-1 text-sm font-medium mb-4 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        Programme Action Solidaire
                    </div>
                    <h1 class="text-3xl font-bold mb-3 font-heading">Missions Bénévoles</h1>
                    <p class="text-blue-50 text-lg">
                        Participez à des actions de terrain avec nos associations partenaires. Rompez l'isolement, recréez du lien social, et gagnez des crédits pour vos prochaines consultations.
                    </p>
                </div>
                <!-- Image d'illustration optionnelle -->
                <div class="hidden md:block">
                    <div class="bg-white/10 w-32 h-32 rounded-full border-4 border-white/20 flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Messages Flash -->
            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-3 flex items-center gap-2">
                    <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-8 bg-red-50 border border-red-300 text-red-800 rounded-xl px-4 py-3">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Sidebar Filtres (Desktop) -->
                <aside class="w-full lg:w-1/4">
                    <x-card class="sticky top-24 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-[var(--color-text-dark)]">Filtres</h2>
                        </div>

                        <div class="space-y-6">
                            <!-- Type d'action -->
                            <div>
                                <h3 class="text-sm font-semibold text-[var(--color-text-dark)] mb-3">Type d'engagement</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary)]">
                                        <span class="ml-2 text-sm text-[var(--color-text-gray)]">Action sur le terrain (Maraudes)</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary)]">
                                        <span class="ml-2 text-sm text-[var(--color-text-gray)]">Ateliers créatifs (Peinture, etc.)</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary)]">
                                        <span class="ml-2 text-sm text-[var(--color-text-gray)]">Nature & Jardinage</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Disponibilité -->
                            <div class="pt-6 border-t border-[var(--color-border-light)]">
                                <h3 class="text-sm font-semibold text-[var(--color-text-dark)] mb-3">Période</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary)]">
                                        <span class="ml-2 text-sm text-[var(--color-text-gray)]">Cette semaine</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" class="rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary)]">
                                        <span class="ml-2 text-sm text-[var(--color-text-gray)]">Le week-end</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </x-card>
                </aside>

                <!-- Liste des Activités -->
                <main class="w-full lg:w-3/4">
                    
                    @if(isset($activities) && count($activities) > 0)
                        <div class="space-y-6">
                             @foreach($activities as $activity)
                            <x-card class="relative flex flex-col sm:flex-row gap-6 hover:border-[var(--color-primary)] hover:shadow-md transition-all overflow-hidden group">
                                
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[var(--color-primary)] opacity-50 group-hover:opacity-100 transition-opacity"></div>
                                
                                <div class="flex-1 flex flex-col justify-between pl-4">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-3">
                                        <div>
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 mb-2">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                {{ $activity->association->name ?? 'Croix-Rouge Française' }}
                                            </div>
                                            <h3 class="text-xl font-bold text-[var(--color-text-dark)]">{{$activity->title}}</h3>
                                        </div>
                                        <div class="flex flex-col sm:items-end">
                                            <!-- Bloc Récompense Séance -->
                                            <div class="bg-gradient-to-br from-red-50 to-pink-50 border border-red-100 p-2 rounded-lg flex items-center gap-2 shadow-sm">
                                                <div class="bg-white p-1 rounded-md">
                                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs font-medium text-gray-500">Récompense</p>
                                                    <p class="text-sm font-bold text-red-700">+{{$activity->free_sessions_earned}} Séance{{$activity->free_sessions_earned > 1 ? 's' : ''}} Psy</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-sm text-[var(--color-text-gray)] line-clamp-2 mb-4 leading-relaxed">
                                        {{$activity->description}}
                                    </p>
                                    
                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                        <div class="flex flex-col gap-1 text-sm text-[var(--color-text-gray)]">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{$activity->scheduled_at ? \Carbon\Carbon::parse($activity->scheduled_at)->translatedFormat('l d F Y à H:i') : 'Date à définir'}}
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                Places : {{$activity->max_participants}} participant(s) max.
                                            </div>
                                        </div>
                                        
                                        <div class="w-full sm:w-auto mt-2 sm:mt-0">
                                            @if(isset($userParticipations[$activity->id]))
                                                @if($userParticipations[$activity->id] === 'pending')
                                                    <div class="w-full text-center inline-flex items-center justify-center rounded-xl px-6 py-2.5 text-sm font-medium bg-gray-100 text-gray-500 border border-gray-200 cursor-not-allowed">
                                                        ⏳ Demande en attente
                                                    </div>
                                                @elseif($userParticipations[$activity->id] === 'accepted')
                                                    <div class="w-full text-center inline-flex items-center justify-center rounded-xl px-6 py-2.5 text-sm font-medium bg-green-50 text-green-700 border border-green-200 cursor-not-allowed">
                                                        ✓ Inscription validée
                                                    </div>
                                                @elseif($userParticipations[$activity->id] === 'attended')
                                                    <div class="w-full text-center inline-flex items-center justify-center rounded-xl px-6 py-2.5 text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200 cursor-not-allowed">
                                                        🌟 Mission réalisée
                                                    </div>
                                                @elseif($userParticipations[$activity->id] === 'rejected')
                                                    <div class="w-full text-center inline-flex items-center justify-center rounded-xl px-6 py-2.5 text-sm font-medium bg-red-50 text-red-700 border border-red-200 cursor-not-allowed">
                                                        ✕ Refusée/Annulée
                                                    </div>
                                                @endif
                                            @else
                                                <form action="{{ route('activities.join', $activity) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full text-center inline-flex items-center justify-center rounded-xl px-6 py-2.5 text-sm font-medium bg-[var(--color-primary)] text-white hover:bg-blue-600 focus:outline-none shadow-sm transition-colors group-hover:shadow-md">
                                                        Rejoindre cette mission
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </x-card>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State (Fallback graphique en dev) -->
                        <div class="text-center bg-white p-10 rounded-3xl border border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune mission pour le moment</h3>
                            <p class="mt-1 text-sm text-gray-500">De nouvelles actions solidaires seront bientôt disponibles.</p>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
