<x-app-layout>
    <div class="h-screen bg-gray-900 overflow-hidden flex flex-col relative">
        
        <!-- En-tête -->
        <div class="absolute top-0 w-full z-10 bg-gradient-to-b from-gray-900 to-transparent p-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[var(--color-primary)] flex items-center justify-center font-bold">
                    {{ substr($appointment->patient->user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="font-bold text-lg leading-tight">Consultation en cours</h2>
                    <p class="text-xs text-gray-300">Dr. {{ $appointment->professional->user->name }} & {{ $appointment->patient->user->name }}</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <span id="connectionStatus" class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-bold border border-yellow-500/30 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                    En attente de l'autre participant...
                </span>
            </div>
        </div>

        <!-- Zone Vidéo -->
        <div class="relative flex-1 flex items-center justify-center bg-black">
            <!-- La vidéo distante (Le Docteur ou le Patient) -->
            <video id="remoteVideo" class="w-full h-full object-cover" autoplay playsinline></video>
            
            <!-- Ma vidéo locale (en petit en bas à droite) -->
            <div class="absolute bottom-24 right-6 w-32 h-48 sm:w-48 sm:h-64 bg-gray-800 rounded-2xl overflow-hidden border-2 border-white/20 shadow-2xl transition-transform hover:scale-105 z-20">
                <video id="localVideo" class="w-full h-full object-cover" autoplay playsinline muted></video>
            </div>
        </div>

        <!-- Contrôles -->
        <div class="absolute bottom-0 w-full z-10 bg-gradient-to-t from-gray-900 to-transparent pb-8 pt-12 flex justify-center items-center gap-6">
            <button id="btnAudio" class="w-14 h-14 bg-gray-800/80 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors shadow-lg border border-white/10">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path></svg>
            </button>
            <button id="btnVideo" class="w-14 h-14 bg-gray-800/80 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors shadow-lg border border-white/10">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
            </button>
            
            <form action="{{ route('dashboard') }}" method="GET" class="ml-4">
                <button type="submit" class="w-14 h-14 bg-red-600 text-white rounded-full flex items-center justify-center hover:bg-red-700 transition-colors shadow-lg shadow-red-900/20">
                    <svg class="w-6 h-6 transform rotate-[135deg]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- SCRIPT WEBRTC (LE CERVEAU DE LA SALLE) -->
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            // ==========================================
            // 1. LES VARIABLES DE BASE
            // ==========================================
            const localVideo = document.getElementById('localVideo');
            const remoteVideo = document.getElementById('remoteVideo');
            const statusBadge = document.getElementById('connectionStatus');
            
            // Un serveur STUN (public et gratuit par Google).
            // Son rôle ? Aider nos deux ordinateurs à trouver leur adresse sur Internet en traversant les box WiFi.
            const rtcConfig = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };
            
            let localStream; // Ma propre vidéo/audio
            let peerConnection; // Le fameux "câble" invisible WebRTC entre les 2 ordis
            const channel = window.Echo.join(`room.{{ $appointment->id }}`); // Le salon secret Reverb

            // ==========================================
            // 2. DEMANDER LA CAMÉRA (Dès l'ouverture)
            // ==========================================
            console.log("🎬 ÉTAPE 1 : J'allume ma caméra locale...");
            try {
                // On prépare notre flux vidéo
                localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                localVideo.srcObject = localStream; // On l'affiche dans la petite case
                console.log("✅ Caméra allumée avec succès !");
            } catch (error) {
                console.error("❌ Impossible de lire la caméra :", error);
                alert("Oups, impossible d'accéder à la caméra. Vérifie les permissions de ton navigateur.");
                return; // On arrête tout si on n'a pas de caméra
            }

            // ==========================================
            // 3. ENTRER DANS LE SALON SECRET (REVERB)
            // ==========================================
            console.log("🚪 ÉTAPE 2 : J'entre dans le salon secret Reverb...");
            
            // "here" : Qui est DÉJÀ dans le salon quand j'arrive ?
            channel.here((users) => {
                console.log(`👥 Nous sommes ${users.length} dans le salon.`);
                if (users.length > 1) {
                    console.log("📞 Quelqu'un est déjà là ! C'est moi qui l'appelle !");
                    startCall(); // Je lance l'appel !
                }
            })
            // "joining" : Quelqu'un vient d'entrer dans le salon APRÈS moi !
            .joining((user) => {
                console.log(`👋 ${user.name} vient d'entrer ! Je l'appelle !`);
                startCall(); // Je lance l'appel !
            })
            // "leaving" : Quelqu'un quitte le salon.
            .leaving((user) => {
                console.log(`🏃 ${user.name} est parti.`);
                statusBadge.innerHTML = 'Participant déconnecté.';
                statusBadge.className = 'px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-xs font-bold';
                remoteVideo.srcObject = null; // On coupe sa vidéo
            });

            // ==========================================
            // 4. LE TÉLÉPHONE (Écouter l'autre)
            // ==========================================
            // Comme on n'utilise pas de contrôleur PHP, les deux navigateurs 
            // se parlent en "chuchotant" via Reverb. On écoute ici :
            channel.listenForWhisper('WebRTCSignal', async (data) => {
                console.log("📩 MESSAGE SECRET REÇU :", data.type);

                // Si je n'ai pas encore préparé mon câble réseau, je le fais
                if (!peerConnection) createPeerConnection();

                try {
                    if (data.type === 'offer') {
                        // 1. Il m'appelle (Offre) ! Je note ses informations réseau.
                        console.log("📞 C'est une OFFRE d'appel. J'enregistre ses coordonnées...");
                        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
                        
                        // 2. Je lui prépare ma Réponse
                        console.log("📝 Je rédige ma RÉPONSE...");
                        const answer = await peerConnection.createAnswer();
                        await peerConnection.setLocalDescription(answer);
                        
                        // 3. Je lui envoie ma réponse
                        console.log("📤 J'envoie ma RÉPONSE à l'autre...");
                        channel.whisper('WebRTCSignal', { type: 'answer', sdp: answer });

                    } else if (data.type === 'answer') {
                        // Il a accepté mon appel ! J'enregistre sa validation.
                        console.log("✅ Il a accepté mon appel ! J'enregistre sa description distante.");
                        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));

                    } else if (data.type === 'candidate') {
                        // C'est un point d'accès réseau (ICE) pour que la vidéo trouve le chemin optimal.
                        console.log("📍 J'ajoute un point d'accès réseau (ICE) venant de l'autre...");
                        await peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
                    }
                } catch (err) {
                    console.error("❌ Erreur pendant l'échange réseau :", err);
                }
            });

            // ==========================================
            // FONCTION A : PRÉPARER LE CÂBLE RÉSEAU
            // ==========================================
            function createPeerConnection() {
                console.log("⚙️ Préparation du câble réseau WebRTC...");
                peerConnection = new RTCPeerConnection(rtcConfig);

                // 1. Injecter MA vidéo dans le câble pour qu'elle parte vers l'autre
                localStream.getTracks().forEach(track => {
                    peerConnection.addTrack(track, localStream);
                });

                // 2. Que faire quand je reçois SA vidéo depuis le câble ?
                peerConnection.ontrack = (event) => {
                    console.log("📺🎉 SA VIDÉO EST ARRIVÉE ! Je l'affiche dans le grand lecteur !");
                    remoteVideo.srcObject = event.streams[0];
                    statusBadge.innerHTML = 'En ligne ❤️';
                    statusBadge.className = 'px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-bold';
                };

                // 3. Dès que mon navigateur trouve comment contourner ma Box WiFi (STUN), je le dis à l'autre
                peerConnection.onicecandidate = (event) => {
                    if (event.candidate) {
                        console.log("📍 Mon navigateur a trouvé un chemin réseau. Je l'envoie à l'autre...");
                        channel.whisper('WebRTCSignal', { type: 'candidate', candidate: event.candidate });
                    }
                };
            }

            // ==========================================
            // FONCTION B : PASSER L'APPEL (L'OFFRE)
            // ==========================================
            async function startCall() {
                createPeerConnection(); // Préparer le câble
                console.log("📝 Je rédige mon OFFRE d'appel...");
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer); // J'enregistre l'offre pour moi
                
                console.log("📤 J'envoie mon OFFRE dans le salon...");
                channel.whisper('WebRTCSignal', { type: 'offer', sdp: offer }); // Je l'envoie !
            }

            // ==========================================
            // GESTION DES BOUTONS MICRO ET CAMÉRA
            // ==========================================
            document.getElementById('btnAudio').addEventListener('click', function() {
                const track = localStream.getAudioTracks()[0];
                track.enabled = !track.enabled; // Toggle on/off
                this.classList.toggle('bg-red-500', !track.enabled);
                this.classList.toggle('bg-gray-800/80', track.enabled);
            });

            document.getElementById('btnVideo').addEventListener('click', function() {
                const track = localStream.getVideoTracks()[0];
                track.enabled = !track.enabled; // Toggle on/off
                this.classList.toggle('bg-red-500', !track.enabled);
                this.classList.toggle('bg-gray-800/80', track.enabled);
            });
        });
    </script>
</x-app-layout>
