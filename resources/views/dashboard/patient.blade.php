<x-app-layout>
    <div class="min-h-screen bg-[#FDFDFF] py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        <x-flash-messages />

        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                        Bonjour, <span class="text-blue-600">{{ auth()->user()->name }}</span>
                    </h1>
                    <p class="mt-3 text-lg text-slate-500 font-medium">Heureux de vous revoir dans votre espace personnel.</p>
                </div>
                
                <!-- Quick Credit View -->
                <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-full shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-50">
                    <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-xl shadow-inner text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Solde Solidaire</p>
                        <p class="text-xl font-black text-slate-800 leading-none">{{ auth()->user()->patient->credits ?? 0 }} <span class="text-sm font-bold text-slate-500">séance(s)</span></p>
                    </div>
                </div>
            </header>

            @php
                $appointments = $appointments ?? collect();
                $featured = $appointments->filter(fn($a) => in_array($a->status, ['in_progress', 'waiting_payment']))->first();
                $otherAppointments = $appointments->filter(fn($a) => $a->id !== ($featured->id ?? null));
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Main Content Area -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Featured Action Card -->
                    @if($featured)
                        <div class="relative overflow-hidden group">
                            <div class="absolute inset-0 bg-blue-600/5 rounded-[2.5rem] -rotate-1 scale-105 transition-transform group-hover:rotate-0"></div>
                            <x-card noPadding class="relative border-blue-100 shadow-[0_20px_50px_rgba(59,130,246,0.08)]">
                                <div class="p-8 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-8">
                                    <div class="flex items-center gap-6">
                                        <div class="w-20 h-20 rounded-3xl bg-blue-600 text-white flex flex-col items-center justify-center shadow-lg shadow-blue-200">
                                            <span class="text-2xl font-black leading-none">{{ \Carbon\Carbon::parse($featured->scheduled_at)->format('d') }}</span>
                                            <span class="text-xs uppercase font-bold opacity-80 mt-1">{{ \Carbon\Carbon::parse($featured->scheduled_at)->format('M') }}</span>
                                        </div>
                                        <div>
                                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600 mb-3 uppercase tracking-wider">Priorité immédiate</div>
                                            <h3 class="text-2xl font-bold text-slate-900 mb-1 leading-tight">Séance avec Dr. {{ $featured->professional->user->name }}</h3>
                                            <p class="text-slate-500 font-medium">Aujourd'hui à {{ \Carbon\Carbon::parse($featured->scheduled_at)->format('H:i') }} • Visio-consultation</p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($featured->status === 'in_progress')
                                            <a href="{{ route('appointments.room', $featured->id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all hover:scale-105 active:scale-95 group">
                                                Rejoindre maintenant
                                                <svg class="w-5 h-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </a>
                                        @else
                                            <a href="{{ route('checkout.show', $featured->id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all hover:scale-105 active:scale-95">
                                                Régler la séance ({{ $featured->price }}€)
                                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </x-card>
                        </div>
                    @endif

                    <!-- Appointments List -->
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                                Mes consultations
                                <span class="bg-slate-100 text-slate-500 text-sm px-3 py-1 rounded-full font-bold">{{ $otherAppointments->count() }}</span>
                            </h2>
                            <a href="{{ route('professionals.index') }}" class="text-blue-600 font-bold text-sm hover:underline flex items-center gap-1">
                                Prendre rendez-vous
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>

                        @if($otherAppointments->isEmpty() && !$featured)
                             <x-card class="bg-white text-center py-20 border-dashed border-2 border-slate-200 shadow-none">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Aucun rendez-vous</h3>
                                <p class="text-slate-500 max-w-sm mx-auto">Vous n'avez pas de consultations passées ou à venir pour le moment.</p>
                            </x-card>
                        @else
                            <div class="space-y-4">
                                @foreach($otherAppointments as $appointment)
                                    <div class="bg-white rounded-3xl p-6 border border-slate-50 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_10px_40px_rgba(0,0,0,0.04)] transition-all flex flex-col sm:flex-row items-center gap-6">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-600 flex flex-col items-center justify-center font-bold">
                                            <span class="text-xl leading-none">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d') }}</span>
                                            <span class="text-[10px] uppercase opacity-60">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M') }}</span>
                                        </div>
                                        <div class="flex-grow text-center sm:text-left">
                                            <h4 class="font-bold text-slate-900 leading-none mb-1">Dr. {{ $appointment->professional->user->name ?? 'Praticien' }}</h4>
                                            <p class="text-sm text-slate-500 font-medium">Session {{ $appointment->type }} • {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('H\h i') }}</p>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            @if($appointment->status === 'paid' || $appointment->status === 'accepted')
                                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] uppercase font-black border border-emerald-100/50">Confirmé</span>
                                            @elseif($appointment->status === 'pending')
                                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] uppercase font-black border border-blue-100/50">En attente</span>
                                            @elseif($appointment->status === 'completed')
                                                <span class="px-3 py-1 bg-slate-50 text-slate-400 rounded-full text-[10px] uppercase font-black border border-slate-100/50">Terminé</span>
                                            @else
                                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] uppercase font-black">{{ $appointment->status }}</span>
                                            @endif
                                            
                                            <span class="text-sm font-bold text-slate-900">{{ $appointment->price }}€</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>
                </div>

                <!-- Sidebar Area -->
                <aside class="lg:col-span-4 space-y-10 sticky top-24">
                    
                    <!-- Quick Actions Card (Dark Section) -->
                    <x-card class="!bg-slate-900 !text-white !p-8 shadow-2xl shadow-slate-200 relative overflow-hidden border-none text-white">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                        <h3 class="text-xl font-bold mb-4 relative z-10">Accès rapide</h3>
                        <div class="space-y-4 relative z-10">
                            <a href="{{ route('professionals.index') }}" class="flex items-center gap-4 p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-colors group">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <span class="font-bold text-sm">Réserver une séance</span>
                            </a>
                            <a href="{{ route('activities.index') }}" class="flex items-center gap-4 p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-colors group">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <span class="font-bold text-sm">Missions solidaires</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-colors group">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-orange-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="font-bold text-sm">Modifier mon profil</span>
                            </a>
                        </div>
                    </x-card>

                    <!-- Solidarity Missions Summary -->
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                             Missions Solidaires
                             <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-ping"></span>
                        </h3>
                        @php $myActivities = $myActivities ?? collect(); @endphp
                        
                        @if($myActivities->isEmpty())
                             <div class="p-6 bg-slate-50 rounded-3xl border border-dashed border-slate-200 text-center">
                                <p class="text-sm text-slate-400 font-medium">Aucune mission solidaire en cours.</p>
                             </div>
                        @else
                            <div class="space-y-4">
                                @foreach($myActivities->take(3) as $activity)
                                    <div class="bg-white rounded-3xl p-5 border border-slate-50 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <h4 class="font-bold text-slate-900 text-sm leading-tight">{{ $activity->title }}</h4>
                                            @if($activity->pivot->status === 'accepted')
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-md text-[9px] font-black uppercase tracking-tighter shrink-0 border border-emerald-100/50">Acceptée</span>
                                            @elseif($activity->pivot->status === 'pending')
                                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-md text-[9px] font-black uppercase tracking-tighter shrink-0 border border-blue-100/50">En attente</span>
                                            @elseif($activity->pivot->status === 'attended')
                                                <span class="px-2 py-0.5 bg-slate-50 text-slate-400 rounded-md text-[9px] font-black uppercase tracking-tighter shrink-0 border border-slate-100/50">Réalisée</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                            <span>📅 {{ \Carbon\Carbon::parse($activity->scheduled_at)->format('d/m') }}</span>
                                            <span class="text-blue-500">🎁 +{{ $activity->free_sessions_earned }} crédits</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($myActivities->count() > 3)
                                <a href="#" class="block text-center mt-4 text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">Voir toutes les missions</a>
                            @endif
                        @endif
                    </div>
                    
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>