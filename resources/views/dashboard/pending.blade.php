<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
        <div class="max-w-lg w-full">

            <!-- Icône d'attente -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-amber-100">
                    <svg class="w-10 h-10 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800">Compte en cours de vérification</h1>
                <p class="mt-2 text-slate-500">Notre équipe examine votre dossier professionnel.</p>
            </div>

            <!-- Carte principale -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-6">

                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Votre compte est en attente</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            Bonjour <span class="font-semibold">Dr. {{ auth()->user()->name }}</span>, votre inscription a bien été reçue.
                            Un administrateur va vérifier vos informations et valider votre accès dans les plus brefs délais.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-emerald-50 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Notification par e-mail</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            Vous recevrez un e-mail à l'adresse <span class="font-semibold">{{ auth()->user()->email }}</span> dès que votre compte sera activé.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-purple-50 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Après l'activation</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            Une fois validé, vous pourrez compléter votre profil (photo, biographie, tarif) et commencer à recevoir des demandes de rendez-vous.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex flex-col items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline font-medium">
                    Actualiser le statut de mon compte
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-400 hover:text-slate-600 transition-colors">
                        Se déconnecter
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>