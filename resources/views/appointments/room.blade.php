<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Téléconsultation - {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900 text-white">

    <div class="h-screen bg-gray-900 overflow-hidden flex flex-col relative">
        
        <!-- En-tête -->
        <div class="absolute top-0 w-full z-30 bg-gradient-to-b from-gray-900 to-transparent p-4 flex justify-between items-center text-white">
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
        <div class="relative flex-1 flex items-center justify-center bg-black overflow-hidden">
            <video id="remoteVideo" class="max-w-full max-h-full w-full h-full object-cover z-0" autoplay playsinline></video>
            
            <!-- Ma vidéo locale — z-50 pour être au-dessus de tout -->
            <div id="localVideoContainer" class="absolute bottom-24 right-6 w-32 h-48 sm:w-48 sm:h-64 bg-gray-800 rounded-2xl overflow-hidden border-2 border-white/20 shadow-2xl transition-all duration-300 hover:scale-105 z-50">
                <video id="localVideo" class="w-full h-full object-cover" autoplay playsinline muted></video>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
            </div>
        </div>

        <!-- Contrôles -->
        <div class="absolute bottom-0 w-full z-40 bg-gradient-to-t from-gray-900 to-transparent pb-8 pt-12 flex justify-center items-center gap-4 sm:gap-6 px-4">
            <button id="btnAudio" class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-800/80 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-all shadow-lg border border-white/10">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path></svg>
            </button>
            <button id="btnVideo" class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-800/80 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-all shadow-lg border border-white/10">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
            </button>
            
            <button id="btnChatToggle" class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-800/80 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-all shadow-lg border border-white/10 relative">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path></svg>
                <span id="chatBadge" class="hidden absolute top-0 right-0 w-3.5 h-3.5 bg-red-500 border-2 border-gray-900 rounded-full"></span>
            </button>
            
            <button id="btnManualCall" onclick="window.startCallManually()" class="w-12 h-12 sm:w-14 sm:h-14 bg-green-600/90 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-green-500 transition-all shadow-lg shadow-green-900/20 border border-white/10" title="Forcer l'appel (Mode manuel)">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </button>

            <form action="{{ route('dashboard') }}" method="GET" class="">
                <button type="submit" class="w-12 h-12 sm:w-14 sm:h-14 bg-red-600 text-white rounded-full flex items-center justify-center hover:bg-red-700 transition-all shadow-lg shadow-red-900/20">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transform rotate-[135deg]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                </button>
            </form>
        </div>

        <!-- Chat Sidebar — cachée par défaut (translate-x-full), ouverte par JS -->
        <div id="chatSidebar" class="absolute top-0 right-0 h-full w-80 bg-gray-800/95 backdrop-blur-xl border-l border-gray-700 shadow-2xl z-40 flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="px-5 py-4 border-b border-gray-700 flex justify-between items-center bg-gray-900/50">
                <h3 class="font-bold text-white">Chat en direct</h3>
                <button id="btnChatClose" class="text-gray-400 hover:text-white transition-colors p-1 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="liveChatMessages" class="flex-1 overflow-y-auto p-4 space-y-3">
                <p class="text-xs text-center text-gray-500 mb-4">Les messages de cet appel ne sont pas sauvegardés.</p>
            </div>
            <div class="p-4 border-t border-gray-700 bg-gray-900/80">
                <div class="flex gap-2">
                    <input type="text" id="liveChatInput" placeholder="Écrire un message..." class="w-full bg-gray-800 text-sm text-white px-3 py-2 rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                    <button id="liveChatSend" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded-lg shadow transition-colors">
                        <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const localVideo = document.getElementById('localVideo');
            const remoteVideo = document.getElementById('remoteVideo');
            const statusBadge = document.getElementById('connectionStatus');
            const rtcConfig = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };
            let localStream; 
            let peerConnection; 
            let isCaller = false;
            let callStarted = false; 
            let queuedCandidates = [];

            // Monitoring de la connexion Echo
            window.Echo.connector.pusher.connection.bind('state_change', (states) => {
                console.log(` Echo State: ${states.current}`);
                if (states.current === 'connected') statusBadge.innerHTML = 'Connexion au serveur...';
                if (states.current === 'unavailable') statusBadge.innerHTML = 'Serveur indisponible ❌';
            });

            const channel = window.Echo.join(`room.{{ $appointment->id }}`); 

            // CHAT SIDEBAR
            const chatSidebar = document.getElementById('chatSidebar');
            const btnChatToggle = document.getElementById('btnChatToggle');
            const btnChatClose = document.getElementById('btnChatClose');
            const chatInput = document.getElementById('liveChatInput');
            const chatBtnSend = document.getElementById('liveChatSend');
            const chatMessagesArea = document.getElementById('liveChatMessages');
            const chatBadge = document.getElementById('chatBadge');
            let isChatOpen = false;

            function openChat() {
                isChatOpen = true;
                chatSidebar.classList.remove('translate-x-full');
                chatSidebar.classList.add('translate-x-0');
                chatBadge.classList.add('hidden');
            }

            function closeChat() {
                isChatOpen = false;
                chatSidebar.classList.remove('translate-x-0');
                chatSidebar.classList.add('translate-x-full');
            }

            btnChatToggle.addEventListener('click', () => isChatOpen ? closeChat() : openChat());
            btnChatClose.addEventListener('click', closeChat);

            function appendMessage(text, isMe = false) {
                const div = document.createElement('div');
                div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
                div.innerHTML = `<div class="max-w-[85%] text-sm px-3 py-2 rounded-xl ${isMe ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-700 text-gray-200 rounded-bl-none'}">${text}</div>`;
                chatMessagesArea.appendChild(div);
                chatMessagesArea.scrollTop = chatMessagesArea.scrollHeight; 
            }

            function sendLiveMessage() {
                const text = chatInput.value.trim();
                if (!text) return;
                appendMessage(text, true);
                channel.whisper('ChatMessage', { text: text });
                chatInput.value = ''; 
            }

            chatBtnSend.addEventListener('click', sendLiveMessage);
            chatInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') sendLiveMessage(); });

            channel.listenForWhisper('ChatMessage', (data) => {
                appendMessage(data.text, false);
                if (!isChatOpen) chatBadge.classList.remove('hidden');
            });

            // 
            // VIDEO CALL 
            console.log("allume ma caméra");
            try {
                localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                localVideo.srcObject = localStream;
            } catch (error) {
                console.log("Caméra inaccessible");
                statusBadge.innerHTML = '⚠️ Caméra inaccessible';
                statusBadge.className = 'px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-bold border border-red-500/30';
            }

            channel.here((users) => {
                console.log(` ${users.length} dans le salon.`);
                // Si on rejoint et qu il y a deja quelqu un, on initie l'appel
                if (users.lenhestartCallregth > 1 && !callStarted) {
                    console.log('initie lappel');
                }
            })
            .joining((user) => {
                console.log(`${user.name} a rejoint. attends son initiation.`);
                startCall(); 
            })
            .leaving((user) => {
                console.log(`${user.name} a quitté.`);
                statusBadge.innerHTML = 'Participant déconnecté.';
                statusBadge.className = 'px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full text-xs font-bold';
                remoteVideo.srcObject = null;
                if (peerConnection) {
                    peerConnection.close();
                    peerConnection = null;
                }
                callStarted = false; 
                queuedCandidates = [];
            });

            channel.listenForWhisper('WebRTCSignal', async (data) => {
                console.log(`Signal reçu: ${data.type}`);

                if (data.type === 'offer' && peerConnection) {
                    console.log("Nouvelle offre reçue : l'interlocuteur a rafraîchi la page. Reconnexion...");
                    peerConnection.close();
                    peerConnection = null;
                    callStarted = false;
                    queuedCandidates = [];
                }

                if (!peerConnection) createPeerConnection();
                
                try {
                    if (data.type === 'offer') {
                        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
                        const answer = await peerConnection.createAnswer();
                        await peerConnection.setLocalDescription(answer);
                        channel.whisper('WebRTCSignal', { type: 'answer', sdp: answer });
                        
                        // Traiter les candidats mis en attente
                        while (queuedCandidates.length > 0) {
                            const candidate = queuedCandidates.shift();
                            await peerConnection.addIceCandidate(candidate);
                        }
                    } else if (data.type === 'answer') {
                        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
                        
                        // Traiter les candidats mis en attente
                        while (queuedCandidates.length > 0) {
                            const candidate = queuedCandidates.shift();
                            await peerConnection.addIceCandidate(candidate);
                        }
                    } else if (data.type === 'candidate') {
                        const candidate = new RTCIceCandidate(data.candidate);
                        if (peerConnection.remoteDescription) {
                            await peerConnection.addIceCandidate(candidate);
                        } else {
                            console.log("Candidat mis en file d'attente");
                            queuedCandidates.push(candidate);
                        }
                    }
                } catch (err) { console.error("Erreur WebRTC :", err); }
            });

            function createPeerConnection() {
                peerConnection = new RTCPeerConnection(rtcConfig);
                
                if (localStream) {
                    localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
                } else {
                    console.log("Mode RecvOnly activé.");
                    peerConnection.addTransceiver('audio', { direction: 'recvonly' });
                    peerConnection.addTransceiver('video', { direction: 'recvonly' });
                }

                peerConnection.ontrack = (event) => {
                    console.log("Flux distant reçu !");
                    if (event.streams && event.streams[0]) {
                        remoteVideo.srcObject = event.streams[0];
                    } else {
                        console.error("Aucun flux trouvé dans l'événement ontrack");
                    }
                    
                    // S'assurer que la vidéo locale reste visible même quand le flux distant arrive
                    const localContainer = document.getElementById('localVideoContainer');
                    if (localContainer) {
                        localContainer.style.display = 'block';
                        localContainer.style.zIndex = '50';
                    }
                };

                peerConnection.onconnectionstatechange = () => {
                    console.log(`État connexion: ${peerConnection.connectionState}`);
                    if (peerConnection.connectionState === 'connected') {
                        statusBadge.innerHTML = 'En ligne ❤️';
                        statusBadge.className = 'px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-bold';
                    }
                    if (peerConnection.connectionState === 'failed' || peerConnection.connectionState === 'disconnected') {
                        statusBadge.innerHTML = 'Connexion perdue...';
                        statusBadge.className = 'px-3 py-1 bg-red-400/20 text-red-300 border border-red-500/30 rounded-full text-xs font-bold';
                    }
                };

                peerConnection.onicecandidate = (event) => {
                    if (event.candidate) {
                        channel.whisper('WebRTCSignal', { type: 'candidate', candidate: event.candidate });
                    }
                };
            }

            async function startCall() {
                if (callStarted) return;
                callStarted = true;
                console.log("Lancement de l'appel");
                
                createPeerConnection(); 
                
                    const offer = await peerConnection.createOffer();
                    await peerConnection.setLocalDescription(offer); 
                    channel.whisper('WebRTCSignal', { type: 'offer', sdp: offer }); 
            }
            
            window.startCallManually = () => {
                console.log("Appel forcé manuellement !");
                startCall();
            };

            // Contrôles Boutons
            document.getElementById('btnAudio').addEventListener('click', function() {
                if (!localStream) return;
                const track = localStream.getAudioTracks()[0];
                if (!track) return;
                track.enabled = !track.enabled; 
                this.classList.toggle('bg-red-500', !track.enabled);
                this.classList.toggle('bg-gray-800/80', track.enabled);
            });

            document.getElementById('btnVideo').addEventListener('click', function() {
                if (!localStream) return;
                const track = localStream.getVideoTracks()[0];
                if (!track) return;
                track.enabled = !track.enabled;
                this.classList.toggle('bg-red-500', !track.enabled);
                this.classList.toggle('bg-gray-800/80', track.enabled);
            });
        });
    </script>
    </body>
</html>
