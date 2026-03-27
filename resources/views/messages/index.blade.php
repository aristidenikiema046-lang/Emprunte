<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-slate-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6 h-[calc(100vh-120px)]">
                
                {{-- SIDEBAR : LISTE DES CONTACTS --}}
                <div class="w-80 bg-[#1e293b]/50 backdrop-blur-xl rounded-[2.5rem] border border-slate-800 p-6 flex flex-col shadow-2xl">
                    <div class="flex items-center justify-between mb-8 px-2">
                        <h3 class="text-2xl font-black italic tracking-tighter uppercase text-white">Inbox</h3>
                        <span class="bg-indigo-500/10 text-indigo-400 text-[10px] font-black px-3 py-1 rounded-full border border-indigo-500/20">
                            {{ $users->count() }} MEMBRES
                        </span>
                    </div>

                    <div class="space-y-2 overflow-y-auto pr-2 custom-scrollbar flex-1">
                        @foreach($users as $user)
                            <a href="{{ route('messages.index', ['user' => $user->id]) }}" 
                               class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-300 group {{ $selectedUserId == $user->id ? 'bg-indigo-600 shadow-xl shadow-indigo-500/20' : 'hover:bg-slate-800 border border-transparent' }}">
                                
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center font-black text-indigo-400 group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    {{-- Indicateur de statut (ex: vert si en ligne) --}}
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-4 border-[#1e293b] rounded-full"></div>
                                </div>

                                <div class="flex flex-col min-w-0">
                                    <span class="text-sm font-bold truncate {{ $selectedUserId == $user->id ? 'text-white' : 'text-slate-300' }}">
                                        {{ $user->name }}
                                    </span>
                                    <span class="text-[10px] uppercase tracking-widest font-bold {{ $selectedUserId == $user->id ? 'text-indigo-200' : 'text-slate-500' }}">
                                        En ligne
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ZONE DE CHAT --}}
                <div class="flex-1 bg-[#1e293b]/50 backdrop-blur-xl rounded-[2.5rem] border border-slate-800 flex flex-col overflow-hidden shadow-2xl relative">
                    @if($selectedUserId)
                        @php $selectedUser = $users->where('id', $selectedUserId)->first(); @endphp
                        
                        {{-- Header du Chat --}}
                        <div class="px-8 py-5 bg-[#0f172a]/40 border-b border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-sm font-black shadow-lg shadow-indigo-500/20">
                                    {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-black text-white uppercase tracking-tight text-sm">{{ $selectedUser->name }}</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                        <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Actif maintenant</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 hover:bg-slate-800 rounded-lg text-slate-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Messages --}}
                        <div id="chat-container" class="flex-1 p-8 overflow-y-auto space-y-8 custom-scrollbar">
                            @foreach($messages as $msg)
                                @php $isMine = $msg->sender_id == auth()->id(); @endphp
                                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }} group animate-fade-in-up">
                                    <div class="max-w-[70%] flex flex-col {{ $isMine ? 'items-end' : 'items-start' }}">
                                        
                                        {{-- Actions au survol --}}
                                        @if($isMine)
                                            <div class="flex gap-3 mb-2 opacity-0 group-hover:opacity-100 transition-all transform translate-y-1 group-hover:translate-y-0">
                                                <button onclick="openEditModal({{ $msg->id }}, '{{ addslashes($msg->content) }}')" class="text-[9px] text-indigo-400 hover:text-white font-black uppercase tracking-tighter">Éditer</button>
                                                <form action="{{ route('messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-[9px] text-red-500 hover:text-red-400 font-black uppercase tracking-tighter">Supprimer</button>
                                                </form>
                                            </div>
                                        @endif

                                        <div class="relative p-4 rounded-[1.5rem] text-sm leading-relaxed {{ $isMine ? 'bg-indigo-600 text-white rounded-tr-none shadow-xl shadow-indigo-500/10' : 'bg-slate-800 text-slate-200 rounded-tl-none border border-slate-700 shadow-lg' }}">
                                            @if($msg->content) <p class="font-medium">{{ $msg->content }}</p> @endif
                                            
                                            @if($msg->file_path)
                                                <div class="mt-3 p-3 bg-black/20 rounded-2xl flex items-center gap-3 border border-white/5 group/file">
                                                    <div class="p-2 bg-indigo-500/20 rounded-lg text-indigo-300 group-hover/file:bg-indigo-500 group-hover/file:text-white transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    </div>
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-[10px] font-black truncate opacity-90 uppercase tracking-tighter">{{ $msg->file_name }}</span>
                                                        <a href="{{ asset('storage/' . $msg->file_path) }}" target="_blank" class="text-[9px] text-indigo-300 hover:text-white font-bold underline mt-0.5">DOWNLOAD</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-[9px] text-slate-600 mt-2 font-black uppercase tracking-widest px-1">
                                            {{ $msg->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Input Area --}}
                        <div class="p-6 bg-slate-900/50 border-t border-slate-800">
                            <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-4 items-center bg-[#1e293b] p-3 rounded-[2rem] border border-slate-700 focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/10 transition-all">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $selectedUserId }}">
                                
                                <label class="cursor-pointer p-3 bg-slate-800 hover:bg-slate-700 rounded-full transition-all text-slate-400 hover:text-indigo-400 border border-slate-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    <input type="file" name="file" class="hidden" onchange="this.form.submit()">
                                </label>

                                <input type="text" name="content" autofocus autocomplete="off" placeholder="Tapez votre message ici..." class="flex-1 bg-transparent border-none text-white focus:ring-0 placeholder-slate-600 text-sm font-medium">
                                
                                <button type="submit" class="bg-indigo-600 p-4 rounded-full hover:bg-indigo-500 transition-all shadow-xl shadow-indigo-500/20 group">
                                    <svg class="h-5 w-5 rotate-45 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- État Vide --}}
                        <div class="flex-1 flex flex-col items-center justify-center text-slate-600">
                            <div class="relative mb-6">
                                <div class="w-32 h-32 bg-[#0f172a] rounded-[3rem] flex items-center justify-center shadow-inner border border-slate-800">
                                    <svg class="w-12 h-12 text-slate-700 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-black shadow-lg">!</div>
                            </div>
                            <h3 class="text-xl font-black uppercase tracking-tighter text-slate-400">Aucune discussion</h3>
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] mt-2 opacity-50">Sélectionnez un collaborateur pour démarrer</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ÉDITION --}}
    <div id="editModal" class="hidden fixed inset-0 bg-[#0f172a]/90 backdrop-blur-md flex items-center justify-center z-50 p-4 transition-all">
        <div class="bg-[#1e293b] border border-slate-700 w-full max-w-md rounded-[3rem] p-10 shadow-3xl transform scale-100">
            <h3 class="text-white font-black italic uppercase tracking-tighter text-2xl mb-6">Modifier</h3>
            <form id="editForm" method="POST">
                @csrf @method('PATCH')
                <div class="relative">
                    <textarea name="content" id="editContent" rows="4" class="w-full bg-[#0f172a] border-slate-700 rounded-[1.5rem] text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 p-5 mb-6 resize-none font-medium"></textarea>
                </div>
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20">Enregistrer les modifications</button>
                    <button type="button" onclick="closeEditModal()" class="w-full py-4 text-slate-500 text-[10px] font-black uppercase tracking-widest hover:text-white transition-colors">Ignorer</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4f46e5; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
    </style>

    <script>
        const container = document.getElementById('chat-container');
        if(container) { container.scrollTop = container.scrollHeight; }

        function openEditModal(id, content) {
            const modal = document.getElementById('editModal');
            document.getElementById('editForm').action = `/messages/${id}`;
            document.getElementById('editContent').value = content;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>