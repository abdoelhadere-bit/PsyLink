<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-[var(--color-background-soft)] py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="max-w-5xl mx-auto mb-6">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-5xl mx-auto mb-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex items-center">
                        <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-[var(--color-text-dark)]">Bonjour, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-[var(--color-text-gray)] mt-1">Gérez vos séances et votre accompagnement psychologique.</p>
                </div>
                <a href="{{ route('professionals.index') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium bg-[var(--color-primary)] text-white hover:bg-blue-600 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)] focus:ring-offset-2">
                    Nouveau Rendez-vous
                </a>
            </div>

            <!-- Liste des séances -->
            <x-card class="shadow-xl bg-white overflow-hidden border border-gray-100 !p-0">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-[var(--color-text-dark)] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Mes Séances
                    </h2>
                </div>
                
                <div class="p-6">
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
                                <div class="group flex flex-col sm:flex-row items-center justify-between p-5 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/20 transition-all duration-300 gap-4 shadow-sm">
                                    <div class="flex items-center gap-4 w-full sm:w-auto">
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
                                    
                                    <div class="flex flex-row items-center w-full sm:w-auto justify-between sm:justify-end border-t sm:border-0 pt-4 sm:pt-0 border-gray-100 gap-6">
                                        <div class="text-right flex flex-col items-end">
                                            @if($appointment->status === 'pending')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-yellow-100 text-yellow-700 shadow-sm border border-yellow-200/50">En attente</span>
                                            @elseif($appointment->status === 'accepted')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-green-100 text-green-700 shadow-sm border border-green-200/50">Confirmé</span>
                                            @elseif($appointment->status === 'rejected' || $appointment->status === 'cancelled')
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-red-100 text-red-700 shadow-sm border border-red-200/50">Refusé/Annulé</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-[11px] uppercase tracking-wide font-bold bg-gray-100 text-gray-700 shadow-sm border border-gray-200/50">{{ $appointment->status }}</span>
                                            @endif
                                            <span class="text-xs font-semibold text-gray-500 mt-1 mr-1">{{ $appointment->price }}€</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>