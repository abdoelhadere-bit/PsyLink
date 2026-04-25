<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- En-tête -->
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-3xl font-extrabold leading-7 text-gray-900 sm:truncate">Centre de Contrôle (Super-Admin)</h2>
                    <p class="mt-2 text-sm text-gray-500">Supervisez l'activité de la plateforme PsyLink, validez ou suspendez les modérateurs.</p>
                </div>
            </div>

            <!-- KPIs -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                    <div class="px-6 py-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Patients Inscrits</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $totalPatients }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                    <div class="px-6 py-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Psychologues Actifs</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $totalPros }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                    <div class="px-6 py-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Séances Honorées</dt>
                                    <dd class="text-3xl font-black text-gray-900">{{ $totalAppointments }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200">

            <!-- Zone d'attente (Dossiers à Valider) -->
            <div>
                <h3 class="text-xl font-bold leading-6 text-gray-900 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-yellow-400 rounded-full mr-2"></span>
                    Demandes en Attente ({{ $pendingPros->count() }})
                </h3>
                
                @if($pendingPros->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center text-gray-500">
                        Aucun nouveau dossier à examiner.
                    </div>
                @else
                    <div class="bg-white shadow overflow-hidden sm:rounded-2xl border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identité</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Création</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingPros as $pro)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl ring-2 ring-white">
                                                        {{ substr($pro->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ str_starts_with($pro->user->name, 'Dr.') ? '' : 'Dr. ' }}{{ $pro->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $pro->specialty ?? 'Spécialité non définie' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $pro->user->email }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $pro->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pro->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" action="{{ route('admin.toggle_status', $pro->id) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 font-bold shadow-sm transition-colors text-sm">
                                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Accepter
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            </div>

            <!-- Zone des Signalements (Plaintes Patients) -->
            <div class="pt-8">
                <h3 class="text-xl font-bold leading-6 text-gray-900 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-red-500 rounded-full mr-2"></span>
                    Signalements en Attente ({{ $pendingReports->count() }})
                </h3>
                
                @if($pendingReports->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center text-gray-500">
                        Aucun signalement à traiter. Tout va bien !
                    </div>
                @else
                    <div class="bg-white shadow overflow-hidden sm:rounded-2xl border border-red-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Signalé par (Patient)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">A l'encontre de (Psy)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider w-1/3">Motif de la plainte</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingReports as $report)
                                    <tr class="hover:bg-red-50/30">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs">
                                                        {{ substr($report->patient->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $report->patient->user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $report->created_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 border-l-2 border-red-400 pl-2">{{ str_starts_with($report->professional->user->name, 'Dr.') ? '' : 'Dr. ' }}{{ $report->professional->user->name }}</div>
                                            <div class="text-xs text-gray-500 pl-2">{{ $report->professional->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100 text-sm whitespace-pre-wrap">{{ $report->reason }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" action="{{ route('reports.resolve', $report->id) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-bold shadow-sm transition-colors text-xs" onclick="return confirm('Avez-vous bien évalué cette plainte et pris les mesures nécessaires (ex: suspension du médecin) avant de la classer ?')">
                                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Classer (Résolu)
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Zone Actifs (Suspensables) -->
            <div class="pt-8">
                <h3 class="text-xl font-bold leading-6 text-gray-900 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-green-500 rounded-full mr-2"></span>
                    Psychologues Actifs ({{ $activePros->count() }})
                </h3>
                
                @if($activePros->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center text-gray-500">
                        Aucun praticien validé pour le moment.
                    </div>
                @else
                    <div class="bg-white shadow overflow-hidden sm:rounded-2xl border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200 opacity-90">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identité / Spécialité</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tarif</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($activePros as $pro)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap flex flex-col justify-center">
                                            <div class="text-sm font-bold text-gray-900 border-l-2 border-green-500 pl-2">{{ str_starts_with($pro->user->name, 'Dr.') ? '' : 'Dr. ' }}{{ $pro->user->name }}</div>
                                            <div class="text-sm text-gray-500 pl-2 mt-1">{{ $pro->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                            {{ number_format($pro->hourly_rate, 2) }} €
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" action="{{ route('admin.toggle_status', $pro->id) }}">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Attention: Voulez-vous vraiment suspendre ce médecin ? Il n\'aura plus accès à la plateforme.')" class="inline-flex items-center px-4 py-2 border border-red-300 text-red-700 bg-white rounded-lg hover:bg-red-50 font-bold transition-colors text-sm">
                                                    <svg class="h-4 w-4 mr-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                    Suspendre
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>