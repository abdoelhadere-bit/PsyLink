<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Soutien Psy') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|poppins:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[var(--color-text-dark)] bg-[var(--color-background-soft)] antialiased min-h-screen flex flex-col">
        
        <!-- Navigation Bar -->
        <nav class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-[var(--color-border-light)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0 flex items-center gap-2">
                            <!-- Logo Placeholder -->
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-emerald-400 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <span class="font-heading font-semibold text-xl tracking-tight text-[var(--color-text-dark)]">SoutienPsy</span>
                        </a>
                        
                        <div class="hidden sm:-my-px sm:ml-10 sm:flex sm:space-x-8">
                            <a href="{{route('professionals.index')}}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors">Trouver un pro</a>
                            <a href="{{route('activities.index')}}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors">Trouver une activite</a>
                            <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors">À propos</a>
                        </div>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        @guest
                            <a href="/login" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Connexion</a>
                            <a href="/register" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold bg-[var(--color-primary)] text-white hover:bg-blue-600 shadow-sm transition-all">S'inscrire</a>
                        @endguest
                        
                        @auth
                            <div class="flex items-center gap-6">
                                <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Mon Profil</a>
                                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-[var(--color-primary)] hover:text-blue-800 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Mon Espace
                                </a>
                                <a href="{{ route('logout') }}" class="text-sm font-medium text-red-500 hover:text-red-700 transition-colors">
                                    Déconnexion
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-[var(--color-border-light)] mt-auto">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center gap-2 mb-4">
                             <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-emerald-400 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <span class="font-heading font-semibold text-xl tracking-tight text-[var(--color-text-dark)]">SoutienPsy</span>
                        </div>
                        <p class="text-sm text-gray-500 max-w-xs">
                            Plateforme de soutien psychologique à distance. Consultez en toute confiance, sécurité et confidentialité.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Liens Utiles</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('professionals.index') }}" class="text-sm text-gray-500 hover:text-gray-900">Trouver un professionnel</a></li>
                            <li><a href="{{ route('about') }}" class="text-sm text-gray-500 hover:text-gray-900">Comment ça marche</a></li>
                            <li><a href="{{ route('activities.index') }}" class="text-sm text-gray-500 hover:text-gray-900">Accès solidaire</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Légal</h3>
                        <ul class="space-y-3">
                            <li><a href="/" class="text-sm text-gray-500 hover:text-gray-900">Mentions légales</a></li>
                            <li><a href="/" class="text-sm text-gray-500 hover:text-gray-900">Confidentialité</a></li>
                            <li><a href="/" class="text-sm text-gray-500 hover:text-gray-900">CGU</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-[var(--color-border-light)] text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} SoutienPsy. Tous droits réservés.
                </div>
            </div>
        </footer>
    </body>
</html>
