<x-app-layout>
    <div class="bg-[var(--color-background-soft)] min-h-screen py-10" x-data="{ tab: 'about' }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-[var(--color-text-gray)]">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-gray-900">Accueil</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="/professionals" class="hover:text-gray-900">Professionnels</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-gray-500 font-medium">Dr. Alice Bernard</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header Card -->
            <x-card class="mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-bl-full -z-10 opacity-50"></div>
                
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="flex-shrink-0 relative">
                        <img class="w-32 h-32 md:w-40 md:h-40 rounded-2xl object-cover shadow-sm ring-4 ring-white" src="https://ui-avatars.com/api/?name=Dr+Alice+B&background=e0f2fe&color=0369a1&size=200" alt="Dr Alice B."/>
                        <div class="absolute -bottom-2 -right-2 bg-green-500 w-5 h-5 rounded-full border-4 border-white" title="En ligne"></div>
                    </div>
                    
                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h1 class="text-3xl font-bold text-[var(--color-text-dark)]">Dr. {{$professional->user->name}}</h1>
                                    <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="Profil vérifié certifié"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                                <p class="text-lg font-medium text-[var(--color-primary)] mb-2">{{$professional->specialty}}</p>
                                
                                <div class="flex items-center gap-1 bg-yellow-50 text-yellow-700 px-3 py-1 rounded-lg inline-flex mb-4">
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <span class="text-base font-bold">4.9</span>
                                    <a href="#" class="text-sm underline ml-1 opacity-75 hover:opacity-100">(42 avis patients)</a>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-auto flex flex-col items-center md:items-end p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <p class="text-sm text-[var(--color-text-gray)] mb-1">Tarif consultation</p>
                                <p class="text-3xl font-bold text-[var(--color-text-dark)] mb-4">{{$professional->hourly_rate}}€ <span class="text-sm font-normal text-gray-500">/ 45 min</span></p>
                                <a href="{{route('appointments.create', $professional->id)}}" class="w-full text-center inline-flex items-center justify-center rounded-xl px-6 py-3 text-base font-semibold bg-[var(--color-primary)] text-white hover:bg-blue-600 shadow-md hover:shadow-lg transition-all transform active:scale-95">
                                    Demander une séance
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Message global success/error pour le profil (ex: Signalement envoyé) --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-3 flex items-center gap-2">
                    <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="mb-6 border-b border-[var(--color-border-light)]">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-[var(--color-primary)] border-[var(--color-primary)]" aria-current="page">
                        À propos
                    </button>
                    <!-- Les autres onglets pourraient être activés via JS, ici mockés statiquement -->
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-[var(--color-text-gray)] hover:text-gray-700 hover:border-gray-300 transition-colors">
                        Disponibilités
                    </button>
                    <button class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-[var(--color-text-gray)] hover:text-gray-700 hover:border-gray-300 transition-colors flex items-center gap-2">
                        Avis <span class="bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">42</span>
                    </button>
                </nav>
            </div>

            <!-- Tab Content: À propos (Défaut) -->
            <div class="space-y-8">
                <section>
                    <h3 class="text-xl font-bold text-[var(--color-text-dark)] mb-4">Présentation</h3>
                    <div class="prose prose-blue max-w-none text-[var(--color-text-gray)] leading-relaxed">
                        <p>{{$professional->bio}}</p>
                    </div>
                </section>

                <div class="grid md:grid-cols-2 gap-8">
                    <section>
                        <h3 class="text-xl font-bold text-[var(--color-text-dark)] mb-4">Spécialités</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">Anxiété & Stress</span>
                            <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">Dépression</span>
                            <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">Troubles du sommeil</span>
                            <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">Confiance en soi</span>
                        </div>
                    </section>

                    <section>
                        <h3 class="text-xl font-bold text-[var(--color-text-dark)] mb-4">Types de consultation</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center text-[var(--color-text-gray)]">
                                <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Visioconférence (45 min)
                            </li>
                            <li class="flex items-center text-[var(--color-text-gray)]">
                                <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Chat écrit sécurisé (45 min)
                            </li>
                        </ul>
                    </section>
                </div>
                
                <!-- Section solidarié informatif -->
                <x-card class="bg-gradient-to-r from-orange-50 to-orange-100 border-orange-200 p-6 flex flex-col sm:flex-row items-center gap-6 mt-8">
                    <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-sm flex-shrink-0">
                        <svg class="w-8 h-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-orange-800 mb-1">Praticien Engagé</h3>
                        <p class="text-sm text-orange-700">Ce professionnel participe au programme de consultations solidaires. Si votre dossier est validé par la plateforme, vous pouvez bénéficier de séances gratuites ou à tarif réduit avec ce praticien.</p>
                    </div>
                </x-card>

                <!-- Zone de Signalement (Patient uniquement) -->
                @auth
                    @if(auth()->user()->role === 'patient')
                        <div class="mt-12 pt-8 border-t border-gray-200" x-data="{ openReport: false }">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Un comportement inapproprié ? Aidez-nous à garder la plateforme sûre.</p>
                                <button @click="openReport = !openReport" type="button" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Signaler ce praticien
                                </button>
                            </div>

                            <div x-show="openReport" x-transition.opacity style="display: {{ $errors->has('reason') ? 'block' : 'none' }};" class="mt-4 bg-white p-6 rounded-2xl border border-red-200 shadow-sm">
                                <h4 class="text-lg font-bold text-red-700 mb-2">Formulaire de signalement</h4>
                                <p class="text-sm text-gray-600 mb-4">Votre plainte sera transmise directement à l'équipe de modération Super-Admin de PsyLink. Le praticien n'en sera pas informé.</p>
                                
                                <form method="POST" action="{{ route('reports.store') }}">
                                    @csrf
                                    <input type="hidden" name="professional_id" value="{{ $professional->id }}">
                                    
                                    <div class="mb-4">
                                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Motif détaillé du signalement *</label>
                                        <textarea id="reason" name="reason" rows="4" placeholder="Veuillez décrire factuellement le problème rencontré (minimum 20 caractères)..."
                                            class="w-full rounded-xl border {{ $errors->has('reason') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} px-4 py-2.5 focus:ring-2 focus:ring-red-400 outline-none">{{ old('reason') }}</textarea>
                                        @error('reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <div class="flex justify-end gap-3">
                                        <button @click="openReport = false" type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium text-sm transition-colors">Annuler</button>
                                        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold text-sm shadow-sm transition-colors">Envoyer le signalement</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</x-app-layout>
