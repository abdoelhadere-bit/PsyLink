<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-[var(--color-background-soft)] py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        <x-flash-messages />

        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-[var(--color-text-dark)]">Bonjour, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-[var(--color-text-gray)] mt-1">Gérez vos séances et votre accompagnement psychologique.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-3 bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100 shadow-sm">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-xl">🎁</div>
                        <div>
                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-0.5">Solde Gratuit</p>
                            <p class="text-lg font-extrabold text-emerald-700 leading-none">{{ auth()->user()->patient->credits ?? 0 }} séance(s)</p>
                        </div>
                    </div>
                    <a href="{{ route('professionals.index') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium bg-[var(--color-primary)] text-white hover:bg-blue-600 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:ring-offset-2">
                        Nouveau Rendez-vous
                    </a>
                </div>
            </div>

            <!-- Content Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Liste des séances -->
            <x-card class="shadow-xl bg-white border border-gray-100 !p-0 flex flex-col h-[600px] overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center sticky top-0 z-10">
                    <h2 class="text-xl font-bold text-[var(--color-text-dark)] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Mes Séances
                    </h2>
                </div>
                
                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                    @php $appointments = $appointments ?? collect(); @endphp
                    
                    @if($appointments->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-blue-50 text-[var(--color-primary)] rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-[var(--color-text-dark)] mb-2">Aucune séance prévue</h3>
                            <p class="text-[var(--color-text-gray)] mb-6 text-sm">Vous n'avez pas encore planifié de consultation. L'annuaire des professionnels est à votre disposition.</p>
                            <a href="{{ route('professionals.index') }}" class="font-semibold text-[var(--color-primary)] hover:text-blue-500 transition-colors hover:underline">Découvrir nos praticiens</a>
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach($appointments as $appointment)
                                <div class="group flex flex-col items-start justify-between p-5 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/20 transition-all duration-300 gap-4 shadow-sm">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 text-[var(--color-primary)] flex flex-col items-center justify-center font-bold text-lg shadow-sm border border-blue-100/50">
                                            <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d') }}</span>
                                            <span class="text-[10px] uppercase font-bold text-blue-500 leading-none">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-[var(--color-text-dark)] mb-0.5">
                                                Le {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('Hh\ i') }}
                                            </p>
                                            <p class="text-xs text-[var(--color-text-gray)] flex items-center gap-2 font-medium">
                                                <span class="{{ $appointment->type === 'video' ? 'text-blue-600 bg-blue-50' : 'text-green-600 bg-green-50' }} px-2 py-0.5 rounded-md">
                                                    {{ ucfirst($appointment->type) === 'Video' ? '📹 Visio' : '💬 Chat' }}
                                                </span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                <span class="text-[var(--color-text-dark)]">Dr. {{ $appointment->professional->user->name ?? 'PsyLink' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center w-full justify-between pt-4 border-t border-gray-100 gap-4 mt-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold text-gray-500">{{ $appointment->price }}€</span>
                                        </div>
                                        <div class="text-right flex items-center justify-end">
                                            @if($appointment->status === 'in_progress')
                                                <a href="{{ route('appointments.room', $appointment->id) }}" class="px-4 py-1.5 rounded-full text-xs uppercase tracking-wide font-bold bg-blue-500 text-white shadow-md hover:bg-blue-600 transition-colors animate-pulse">Rejoindre la visio 🎥</a>
                                            @elseif($appointment->status === 'pending')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-yellow-100 text-yellow-700 shadow-sm border border-yellow-200/50">En attente</span>
                                            @elseif($appointment->status === 'waiting_payment')
                                                <a href="{{ route('checkout.show', $appointment->id) }}" class="px-4 py-1.5 rounded-full text-xs uppercase tracking-wide font-bold bg-amber-500 text-white shadow-md hover:bg-amber-600 transition-colors">💳 Payer {{ $appointment->price }}€</a>
                                            @elseif($appointment->status === 'paid' || $appointment->status === 'accepted')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-green-100 text-green-700 shadow-sm border border-green-200/50">✔️ Confirmé & Payé</span>
                                            @elseif($appointment->status === 'rejected' || $appointment->status === 'cancelled')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-red-100 text-red-700 shadow-sm border border-red-200/50">Refusé/Annulé</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-gray-100 text-gray-700 shadow-sm border border-gray-200/50">{{ $appointment->status }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-card>

            <!-- Liste des missions solidaires -->
            <x-card class="shadow-xl bg-white border border-gray-100 !p-0 flex flex-col h-[600px] overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center sticky top-0 z-10">
                    <h2 class="text-xl font-bold text-[var(--color-text-dark)] flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        Mes Missions Solidaires
                    </h2>
                </div>
                
                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                    @php $myActivities = $myActivities ?? collect(); @endphp
                    
                    @if($myActivities->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-[var(--color-text-dark)] mb-2">Aucune mission solidaire</h3>
                            <p class="text-[var(--color-text-gray)] mb-6 text-sm">Vous n'avez pas encore postulé à une mission d'aide associative.</p>
                            <a href="{{ route('activities.index') }}" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors hover:underline">Découvrir les missions</a>
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach($myActivities as $activity)
                                <div class="group flex flex-col items-start justify-between p-5 rounded-2xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/20 transition-all duration-300 gap-4 shadow-sm">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 flex flex-col items-center justify-center font-bold text-lg shadow-sm border border-emerald-100/50">
                                            <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($activity->scheduled_at)->format('d') }}</span>
                                            <span class="text-[10px] uppercase font-bold text-emerald-500 leading-none">{{ \Carbon\Carbon::parse($activity->scheduled_at)->format('M') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-[var(--color-text-dark)] mb-0.5">
                                                {{ $activity->title }}
                                            </p>
                                            <p class="text-xs text-[var(--color-text-gray)] flex items-center gap-2 font-medium">
                                                <span>{{ \Carbon\Carbon::parse($activity->scheduled_at)->format('d/m/Y à H:i') }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                <span class="text-red-500 font-bold">🎁 +{{ $activity->free_sessions_earned }} séance(s)</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center w-full justify-between pt-4 border-t border-gray-100 gap-4 mt-2">
                                        <div class="text-left">
                                            <span class="text-[10px] text-gray-400 font-medium tracking-wide">Demande envoyée le {{ \Carbon\Carbon::parse($activity->pivot->created_at)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="text-right flex items-center justify-end">
                                            @if($activity->pivot->status === 'pending')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-yellow-100 text-yellow-700 shadow-sm border border-yellow-200/50">En attente</span>
                                            @elseif($activity->pivot->status === 'accepted')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-green-100 text-green-700 shadow-sm border border-green-200/50">Demande Acceptée</span>
                                            @elseif($activity->pivot->status === 'attended')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-blue-100 text-blue-700 shadow-sm border border-blue-200/50">Mission Réalisée ✓</span>
                                            @elseif($activity->pivot->status === 'rejected')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-gray-100 text-gray-700 shadow-sm border border-gray-200/50">Refusée</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                </div>
            </x-card>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-app-layout>