<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                            <p class="font-bold">Erreur</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                            <p class="font-bold">Succès</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Mes Rendez-vous</h2>
                        <a href="{{ route('professional.profile.edit') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 shadow flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Modifier mon profil
                        </a>
                    </div>
                    
                    @if($appointments->isEmpty())
                        <p class="text-gray-500">Vous n'avez aucun rendez-vous pour le moment.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($appointments as $appointment)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-lg font-semibold">Rendez-vous avec {{ $appointment->patient->user->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ ucfirst($appointment->type) }} - {{ ucfirst($appointment->status) }}</p>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $appointment->scheduled_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    
                                    <div class="flex space-x-2 mt-4">
                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{ route('appointments.accept', $appointment->id) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">Accepter</button>
                                            </form>
                                            <form method="POST" action="{{ route('appointments.reject', $appointment->id) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-black rounded hover:bg-red-600">Refuser</button>
                                            </form>
                                        @endif
                                        
                                        @if($appointment->status === 'waiting_payment')
                                            <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed border border-gray-200">En attente de paiement ⌛</button>
                                        @elseif($appointment->status === 'paid' || $appointment->status === 'accepted')
                                            @php
                                                $scheduledAt = \Carbon\Carbon::parse($appointment->scheduled_at);
                                                $allowedStartTime = $scheduledAt->copy()->subMinutes(15);
                                            @endphp
                                          
                                                <form method="POST" action="{{ route('appointments.start', $appointment->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-bold shadow-md animate-pulse">Lancer la séance 🎥</button>
                                                </form>
                                        @endif
                                        
                                        @if($appointment->status === 'in_progress')
                                            <div class="flex space-x-2">
                                                <a href="{{ route('appointments.room', $appointment->id) }}" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 font-bold shadow-md text-sm flex items-center">Rejoindre la visio 🎥</a>
                                                <form method="POST" action="{{ route('appointments.complete', $appointment->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 font-bold shadow-md text-sm flex items-center" onclick="return confirm('Êtes-vous sûr de vouloir terminer définitivement cette séance ?');">Terminer 🚫</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>