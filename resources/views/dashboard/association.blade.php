<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8" x-data="{ openForm: {{ $errors->any() ? 'true' : 'false' }} }">

            <!-- En-tête + succès/erreur -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Espace Association</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Bienvenue, <span class="font-semibold">{{ $association->name ?? auth()->user()->name }}</span>
                    </p>
                </div>
                <button @click="openForm = !openForm" class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Ajouter Mission
                </button>
            </div>

            <x-flash-messages />

            <!-- Formulaire de création de mission -->
            <div x-show="openForm" x-transition.opacity.duration.300ms class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" style="display: none;">
                <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                    Créer une nouvelle Mission Solidaire
                </h3>
                <form method="POST" action="{{ route('activities.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf
                    {{-- Titre --}}

                    <input type="hidden" name="association_id" value="{{$association->id}}">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre de la mission *</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="Ex: Distribution de repas chauds"
                            class="w-full rounded-xl border {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 outline-none">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea id="description" name="description" rows="3" placeholder="Décrivez le contenu et le but de cette action de terrain..."
                            class="w-full rounded-xl border {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 outline-none">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    {{-- Date --}}
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-1">Date & Heure *</label>
                        <input id="scheduled_at" name="scheduled_at" type="datetime-local" value="{{ old('scheduled_at') }}"
                            class="w-full rounded-xl border {{ $errors->has('scheduled_at') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 outline-none">
                        @error('scheduled_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    {{-- Places --}}
                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">Nombre de places max *</label>
                        <input id="max_participants" name="max_participants" type="number" min="2" max="500" value="{{ old('max_participants', 10) }}"
                            class="w-full rounded-xl border {{ $errors->has('max_participants') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 outline-none">
                        @error('max_participants') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    {{-- Type --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Thème / Type <span class="text-gray-400">(optionnel)</span></label>
                        <input id="type" name="type" type="text" value="{{ old('type') }}" placeholder="Ex: Maraude, Jardinage partagé..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 outline-none">
                    </div>
                    {{-- Free Sessions Earned --}}
                    <div>
                        <label for="free_sessions_earned" class="block text-sm font-medium text-gray-700 mb-1">Séances Psy offertes en récompense *</label>
                        <input id="free_sessions_earned" name="free_sessions_earned" type="number" min="0" max="5" value="{{ old('free_sessions_earned', 1) }}"
                            class="w-full rounded-xl border {{ $errors->has('free_sessions_earned') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 outline-none">
                        @error('free_sessions_earned') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow hover:bg-indigo-700 transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Publier la Mission
                        </button>
                    </div>
                </form>
            </div>

            <!-- Demandes de participation en attente -->
            @if($pendingParticipations->isNotEmpty())
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-2 h-6 bg-yellow-400 rounded-full"></span>
                    Demandes en Attente ({{ $pendingParticipations->count() }})
                </h3>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Patient</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mission</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pendingParticipations as $p)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->patient->user->display_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $p->activity->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                    <form method="POST" action="{{ route('participations.validate', $p->id) }}">
                                        @csrf
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-lg hover:bg-green-600">✓ Accepter</button>
                                    </form>
                                    <form method="POST" action="{{ route('participations.validate', $p->id) }}">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="px-3 py-1.5 border border-red-300 text-red-600 text-xs font-bold rounded-lg hover:bg-red-50">✕ Refuser</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Liste des missions publiées -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-2 h-6 bg-green-500 rounded-full"></span>
                    Vos Missions ({{ $activities->count() }})
                </h3>

                @if($activities->isEmpty())
                    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-400">
                        Vous n'avez pas encore publié de missions. Utilisez le formulaire ci-dessus !
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($activities as $activity)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $activity->title }}</h4>
                                    @if($activity->type)
                                        <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">{{ $activity->type }}</span>
                                    @endif
                                    @if($activity->free_sessions_earned > 0)
                                        <span class="text-xs bg-red-50 text-red-700 px-2 py-0.5 rounded-full border border-red-100 ml-1">🎁 +{{ $activity->free_sessions_earned }} séance(s)</span>
                                    @endif
                                </div>
                                {{-- Badge statut date --}}
                                @if($activity->scheduled_at < now())
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-lg">Terminée</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 font-bold px-2 py-1 rounded-lg">À venir</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $activity->description }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span>📅 {{ $activity->scheduled_at ? $activity->scheduled_at->format('d/m/Y à H:i') : 'Date non définie' }}</span>
                                <span>👥 {{ $activity->validated_count }}/{{ $activity->max_participants }} places</span>
                                <span>⏳ {{ $activity->participations_count - $activity->validated_count }} en attente</span>
                            </div>
                            {{-- Barre de progression des places --}}
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-indigo-500 h-1.5 rounded-full transition-all" style="width: {{ $activity->fill_rate }}%"></div>
                            </div>
                            
                            {{-- Validation des présences si la mission est passée --}}
                            @if($activity->scheduled_at < now() && $activity->participations->isNotEmpty())
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-sm font-bold text-gray-700 mb-2">Validation des présences</p>
                                    <div class="space-y-2">
                                        @foreach($activity->participations as $participation)
                                            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg text-sm">
                                                <span class="font-medium text-gray-800">{{ $participation->patient->user->display_name }}</span>
                                                @if($participation->status === 'attended')
                                                    <span class="text-green-600 font-bold text-xs bg-green-100 px-2 py-1 rounded">Crédité ✓</span>
                                                @else
                                                    <div class="flex gap-1 border border-gray-200 p-1 bg-white rounded-lg">
                                                        <form method="POST" action="{{ route('participations.validate', $participation->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="action" value="mark_present">
                                                            <button title="Présent (Accorder les crédits)" class="w-7 h-7 bg-green-100 text-green-600 rounded-md hover:bg-green-200 flex items-center justify-center font-bold">✓</button>
                                                        </form>
                                                        <form method="POST" action="{{ route('participations.validate', $participation->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="action" value="mark_absent">
                                                            <button title="Absent (Refuser les crédits)" class="w-7 h-7 bg-red-100 text-red-600 rounded-md hover:bg-red-200 flex items-center justify-center font-bold">✕</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Bouton supprimer --}}
                            @if($activity->scheduled_at > now())
                                <form method="POST" action="{{ route('activities.destroy', $activity->id) }}"
                                    onsubmit="return confirm('Confirmer la suppression de cette mission ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full text-center text-xs text-red-500 hover:text-red-700 mt-2 transition">
                                        🗑 Supprimer cette mission
                                    </button>
                                </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
