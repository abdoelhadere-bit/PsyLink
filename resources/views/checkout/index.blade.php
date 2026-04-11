<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100">
                <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">Paiement Sécurisé</h2>
            <p class="mt-2 text-sm text-gray-600">
                Séance avec Dr. {{ $appointment->professional->user->name }}
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-gray-100">
                
                <!-- Récapitulatif -->
                <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-100 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-bold mb-1">Total à payer</p>
                        <p class="text-2xl font-black text-gray-900">{{ number_format($appointment->price, 2) }} €</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-medium">Pour la séance du :</p>
                        <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if(auth()->user()->patient->credits > 0)
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl">
                        <p class="text-sm font-bold text-red-600 mb-3 flex items-center gap-2">
                           ❤️ Vous possédez {{ auth()->user()->patient->credits }} cœurs solidaires.
                        </p>
                        <form action="{{ route('checkout.process', $appointment->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="use_credits" value="1">
                            <button class="w-full !bg-red-500 !text-white !border-none hover:bg-red-600">
                                Payer avec 1 Cœur Solidaire
                            </button>
                        </form>
                    </div>
                @endif
                <!-- Formulaire -->
                <form class="space-y-5" action="{{ route('checkout.process', $appointment->id) }}" method="POST">
                    @csrf
                    
                    <div>
                        <label for="card_name" class="block text-sm font-medium text-gray-700">Nom sur la carte</label>
                        <div class="mt-1">
                            <input id="card_name" name="card_name" type="text" required value="{{ old('card_name', auth()->user()->name) }}" class="appearance-none block w-full px-4 py-3 border @error('card_name') border-red-300 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors">
                            @error('card_name')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-700">Numéro de carte</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <input id="card_number" name="card_number" type="text" required value="{{ old('card_number') }}" placeholder="0000 0000 0000 0000" class="pl-10 appearance-none block w-full px-4 py-3 border @error('card_number') border-red-300 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono tracking-widest transition-colors">
                        </div>
                        @error('card_number')
                            <p class="mt-2 text-sm text-red-600 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="exp_date" class="block text-sm font-medium text-gray-700">Expiration</label>
                            <div class="mt-1">
                                <input id="exp_date" name="exp_date" type="text" required value="{{ old('exp_date') }}" placeholder="MM/AA" class="appearance-none block w-full px-4 py-3 border @error('exp_date') border-red-300 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono transition-colors">
                                @error('exp_date')
                                    <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="cvc" name="cvc" type="text" required value="{{ old('cvc') }}" placeholder="123" class="appearance-none block w-full px-4 py-3 border @error('cvc') border-red-300 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono transition-colors">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v-2H2v-4h4.257a6 6 0 1111.743-1.743zM8 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                            @error('cvc')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center mt-6">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-xs text-gray-500">Paiement crypté et sécurisé.</span>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all uppercase tracking-wider">
                            Payer {{ number_format($appointment->price, 2) }} €
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 font-medium">← Annuler et retourner au tableau de bord</a>
            </div>
        </div>
    </div>
</x-app-layout>
