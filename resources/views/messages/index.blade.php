<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-slate-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6 h-[calc(100vh-150px)]">
                
                <div class="w-80 bg-[#1e293b] rounded-[2rem] border border-slate-700/50 p-6 flex flex-col shadow-xl">
                    <h3 class="text-xl font-bold mb-6 italic px-2">Messagerie</h3>
                    <div class="space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold px-2 mb-2">Destinataires</p>
                        @foreach($users as $user)
                            <a href="{{ route('messages.index', ['user' => $user->id]) }}" 
                               class="flex items-center gap-3 p-4 rounded-2xl transition-all duration-300 {{ $selectedUserId == $user->id ? 'bg-indigo-600 shadow-lg shadow-indigo-500/20' : 'bg-[#0f172a]/50 hover:bg-slate-700 border border-slate-700/30' }}">
                                <div class="w-10 h-10 rounded-full bg-slate-800 border border-indigo-500/30 flex items-center justify-center font-bold text-indigo-400">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold truncate">{{ $user->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex-1 bg-[#1e293b] rounded-[2rem] border border-slate-700/50 flex flex-col overflow-hidden shadow-2xl relative">
                    @if($selectedUserId)
                        @php $selectedUser = $users->where('id', $selectedUserId)->first(); @endphp
                        <div class="p-4 bg-[#0f172a]/30 border-b border-slate-700/50 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                            </div>
                            <span class="font-bold text-sm">{{ $selectedUser->name }}</span>
                        </div>

                        <div id="chat-container" class="flex-1 p-6 overflow-y-auto space-y-6 bg-[#0f172a]/20 custom-scrollbar flex flex-col">
                            @foreach($messages as $msg)
                                @php $isMine = $msg->sender_id == auth()->id(); @endphp
                                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }} group">
                                    <div class="max-w-[75%] flex flex-col {{ $isMine ? 'items-end' : 'items-start' }}">
                                        
                                        @if($isMine)
                                            <div class="flex gap-2 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button onclick="openEditModal({{ $msg->id }}, '{{ addslashes($msg->content) }}')" class="text-[10px] text-slate-500 hover:text-indigo-400 font-bold uppercase">Modifier</button>
                                                <form action="{{ route('messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-[10px] text-slate-500 hover:text-red-500 font-bold uppercase">Supprimer</button>
                                                </form>
                                            </div>
                                        @endif

                                        <div class="p-4 rounded-2xl text-sm shadow-sm {{ $isMine ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-[#334155] text-slate-200 rounded-tl-none border border-slate-600/30' }}">
                                            @if($msg->content) <p>{{ $msg->content }}</p> @endif
                                            
                                            @if($msg->file_path)
                                                <div class="mt-3 p-2 bg-black/20 rounded-xl flex items-center gap-3 border border-white/5">
                                                    <span class="text-lg">📄</span>
                                                    <div class="flex flex-col min-w-0">
                                                        <span class="text-[10px] font-bold truncate opacity-80">{{ $msg->file_name }}</span>
                                                        <a href="{{ asset('storage/' . $msg->file_path) }}" target="_blank" class="text-[10px] text-indigo-300 hover:text-white underline font-bold mt-1">Télécharger</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-[9px] text-slate-500 mt-1 block px-2 font-mono">
                                            {{ $msg->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-6 bg-[#1e293b]">
                            <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-3 items-center bg-[#0f172a] p-2 rounded-2xl border border-slate-700/50 focus-within:border-indigo-500 transition-all shadow-inner">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $selectedUserId }}">
                                
                                <label class="cursor-pointer p-3 hover:bg-slate-800 rounded-xl transition text-slate-400 hover:text-indigo-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <input type="file" name="file" class="hidden" onchange="this.form.submit()">
                                </label>

                                <input type="text" name="content" autofocus autocomplete="off" placeholder="Écrivez votre message..." class="flex-1 bg-transparent border-none text-white focus:ring-0 placeholder-slate-600 text-sm">
                                
                                <button type="submit" class="bg-indigo-600 p-3 rounded-xl hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/40 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-90 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-slate-500 space-y-6">
                            <div class="w-24 h-24 bg-[#0f172a] rounded-full flex items-center justify-center shadow-inner">
                                <span class="text-4xl animate-pulse">💬</span>
                            </div>
                            <p class="text-sm font-medium tracking-wide italic">Sélectionnez un membre pour discuter</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-[#1e293b] border border-slate-700 w-full max-w-md rounded-[2rem] p-8 shadow-2xl">
            <h3 class="text-white font-bold mb-4">Modifier le message</h3>
            <form id="editForm" method="POST">
                @csrf @method('PATCH')
                <textarea name="content" id="editContent" rows="4" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white text-sm focus:ring-indigo-500 mb-4"></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-slate-400 text-xs font-bold uppercase">Annuler</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-xl text-xs font-bold uppercase transition">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>

    <script>
        // Auto-scroll vers le bas
        const container = document.getElementById('chat-container');
        if(container) { container.scrollTop = container.scrollHeight; }

        // Fonctions Modal
        function openEditModal(id, content) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const textarea = document.getElementById('editContent');
            
            form.action = `/messages/${id}`;
            textarea.value = content;
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>