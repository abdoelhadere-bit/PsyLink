<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[var(--color-background-soft)] bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%233b82f6\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]">
        
        <x-card class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur-xl shadow-xl border-white/50 relative overflow-hidden">
            <!-- Decorative blur blob -->
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <div class="relative z-10">
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-emerald-400 flex items-center justify-center shadow-md mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-[var(--color-text-dark)]">
                        Bon retour
                    </h2>
                    <p class="mt-2 text-sm text-[var(--color-text-gray)]">
                        Accédez à votre espace sécurisé
                    </p>
                </div>

                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-[var(--color-text-dark)] mb-1">
                                Adresse email
                            </label>
                            <x-input id="email" name="email" type="email" autocomplete="email" required class="w-full bg-white/50" placeholder="vous@exemple.com" />
                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-sm font-medium text-[var(--color-text-dark)]">
                                    Mot de passe
                                </label>
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-[var(--color-primary)] hover:text-blue-500 transition-colors">
                                        Mot de passe oublié ?
                                    </a>
                                </div>
                            </div>
                            <x-input id="password" name="password" type="password" autocomplete="current-password" required class="w-full bg-white/50" placeholder="••••••••" />
                            @error('password')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-[var(--color-primary)] focus:ring-[var(--color-primary)] border-gray-300 rounded transition-colors">
                        <label for="remember-me" class="ml-2 block text-sm text-[var(--color-text-gray)]">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div>
                        <x-button type="submit" variant="primary" class="w-full shadow-md hover:shadow-lg transition-all transform active:scale-[0.98]">
                            Se connecter
                        </x-button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm">
                    <p class="text-[var(--color-text-gray)]">
                        Nouveau sur la plateforme ?
                        <a href="/register" class="font-semibold text-[var(--color-primary)] hover:text-blue-500 transition-colors">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
