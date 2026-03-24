<x-app-layout>
    <!-- Header Hero -->
    <section class="relative bg-[var(--color-primary)] text-white pt-24 pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10">
            <!-- Pattern -->
            <svg class="absolute right-0 top-0 h-[500px] w-[500px] transform translate-x-1/3 -translate-y-1/4" fill="currentColor" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="50"></circle>
            </svg>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-6 text-white">À propos de SoutienPsy</h1>
            <p class="text-xl text-blue-100 leading-relaxed max-w-2xl mx-auto">
                Notre mission est de rendre le soutien psychologique accessible, sûr et humain pour tous, sans exception.
            </p>
        </div>
    </section>

    <!-- La mission -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-20">
        <x-card class="shadow-xl mb-16 border-t-4 border-t-[var(--color-secondary)]">
            <div class="md:grid md:grid-cols-2 md:gap-12 items-center">
                <div class="mb-8 md:mb-0">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-[var(--color-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-[var(--color-text-dark)] mb-4">Pourquoi cette plateforme ?</h2>
                    <p class="text-lg text-[var(--color-text-gray)] mb-4 leading-relaxed">
                        Le besoin d'écoute et d'accompagnement n'a jamais été aussi fort. Pourtant, franchir la porte d'un cabinet reste une étape difficile pour de nombreuses personnes, que ce soit par peur du jugement, par manque de temps ou de moyens financiers.
                    </p>
                    <p class="text-[var(--color-text-gray)] leading-relaxed">
                        SoutienPsy est né d'une volonté simple : <strong class="font-medium text-[var(--color-text-dark)]">abattre ces barrières</strong> en connectant directement les personnes en demande à un réseau de professionnels qualifiés et bienveillants via un espace en ligne rassurant, de manière sécurisée.
                    </p>
                </div>
                <!-- Image Placholder (Absctract art or Illustration) -->
                <div class="w-full h-80 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-[var(--color-border-light)] p-8 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 top-1/2 left-1/4 transform -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute w-64 h-64 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 bottom-0 right-1/4 translate-x-1/4 translate-y-1/4"></div>
                </div>
            </div>
        </x-card>

        <!-- Nos Valeurs -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-[var(--color-text-dark)]">Nos engagements fondamentaux</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <x-card class="text-center hover:shadow-md transition-shadow">
                <div class="w-14 h-14 mx-auto rounded-full bg-blue-100 flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Sécurité & Validation</h3>
                <p class="text-[var(--color-text-gray)]">Chaque praticien présent sur la plateforme a vu ses diplômes vérifiés par notre équipe de modération. Nous ne transigeons pas avec la qualité des soins.</p>
            </x-card>

            <x-card class="text-center hover:shadow-md transition-shadow">
                <div class="w-14 h-14 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Confidentialité</h3>
                <p class="text-[var(--color-text-gray)]">Des échanges couverts par le secret professionnel, un cryptage des appels vidéos et textuels, et la possibilité pour l'utilisateur de recourir à l'anonymat pour consulter.</p>
            </x-card>

            <x-card class="text-center hover:shadow-md transition-shadow">
                <div class="w-14 h-14 mx-auto rounded-full bg-orange-100 flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Accès pour tous</h3>
                <p class="text-[var(--color-text-gray)]">Grâce à l'initiative solidaire embarquée, la plateforme intègre un système d'accès à des séances subventionnées ou dispensées par des professionnels de santé bénévoles.</p>
            </x-card>
        </div>
    </section>

    <!-- Partenaires (Optionnel) -->
    <section class="py-16 bg-white border-y border-[var(--color-border-light)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-8">Ils nous font confiance</p>
            <div class="flex flex-wrap justify-center gap-12 opacity-50 grayscale hover:grayscale-0 transition-all">
                <!-- Logos Placeholders -->
                <div class="text-xl font-bold font-serif">Partenaire Santé</div>
                <div class="text-xl font-bold font-serif">Asso. PsyFrance</div>
                <div class="text-xl font-bold font-serif">Ministère Santé</div>
                <div class="text-xl font-bold font-serif">Mutuelle+</div>
            </div>
        </div>
    </section>

    <!-- Contact Block -->
    <section class="py-24 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-[var(--color-text-dark)] mb-4">Une question particulière ?</h2>
        <p class="text-lg text-[var(--color-text-gray)] mb-8">Notre équipe est à votre disposition pour vous accompagner dans l'utilisation de la plateforme.</p>
        <div class="inline-flex flex-col sm:flex-row gap-4 justify-center w-full">
            <x-button variant="secondary" class="!px-8 !py-4 shadow-sm">Nous contacter</x-button>
            <x-button variant="primary" class="!px-8 !py-4 shadow-md">Centre d'Aide</x-button>
        </div>
    </section>
</x-app-layout>
