<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Mes Rendez-vous</h2>
                    
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
                                            <form method="POST" action="{{ route('appointments.start', $appointment->id) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-bold shadow-md">Commencer la séance 🎥</button>
                                            </form>
                                        @endif
                                        
                                        @if($appointment->status === 'in_progress')
                                            <form method="POST" action="{{ route('appointments.complete', $appointment->id) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-purple-500 text-black rounded hover:bg-purple-600">Terminer</button>
                                            </form>
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