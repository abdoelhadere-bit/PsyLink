<x-app-layout>

    <div class="max-w-4xl mx-auto my-8 bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700 flex flex-col h-[70vh]">

        <!-- Header -->

        <div class="px-6 py-4 border-b border-gray-700 bg-gray-900 flex items-center justify-between">

            <h2 class="text-lg font-bold text-white flex items-center gap-3">

                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>

                Conversation avec {{ $user->name }}

            </h2>

            <a href="{{ route('messages.index') }}" class="text-sm text-gray-400 hover:text-white">Retour</a>

        </div>

        <!-- Zone des Messages -->

        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-900/50" id="chat-box">

            @foreach($messages as $msg)

                <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">

                    <div class="max-w-xs px-4 py-3 rounded-2xl {{ $msg->sender_id == Auth::id() ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-700 text-gray-200 rounded-bl-none' }}">

                        {{ $msg->content }}

                        <span class="block text-[10px] text-white/50 mt-1 {{ $msg->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">

                            {{ $msg->created_at->format('H:i') }}

                        </span>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- Zone de Saisie -->

        <div class="p-4 bg-gray-800 border-t border-gray-700">

            <form action="{{ route('messages.store', $user->id) }}" method="POST" class="flex gap-3">

                @csrf

                <input type="text" name="content" placeholder="Écrivez votre message..." autocomplete="off"

                       class="flex-1 bg-gray-900 border border-gray-600 text-white rounded-full px-5 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">

                <button type="submit" class="w-12 h-12 bg-blue-600 hover:bg-blue-500 text-white rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-105">

                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>

                </button>

            </form>

        </div>

    </div>

</x-app-layout>