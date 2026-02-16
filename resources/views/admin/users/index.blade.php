<x-app-layout>
    <div class="p-6 bg-[#0f172a] min-h-screen text-slate-200">
        
        {{-- Header avec Statistiques --}}
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-2xl font-black italic uppercase tracking-widest text-white">
                    Gestion <span class="text-blue-500">Équipe</span>
                </h2>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter mt-1">
                    Total : {{ $users->count() }} collaborateurs
                </p>
            </div>
            
            <button onclick="document.getElementById('modal-user').classList.remove('hidden')" 
                    class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un membre
            </button>
        </div>

        {{-- Table des Utilisateurs --}}
        <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-8 py-5">Collaborateur</th>
                        <th class="px-8 py-5">Email</th>
                        <th class="px-8 py-5 text-center">Rôle</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-800/30 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center font-black text-white shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-slate-200">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-400 font-mono">{{ $user->email }}</td>
                        <td class="px-8 py-5 text-center">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.updateRole', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all hover:scale-105 {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
                                        {{ $user->role === 'admin' ? 'Admin' : 'Employé' }}
                                    </button>
                                </form>
                            @else
                                <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-800 text-slate-500 border border-slate-700">
                                    Admin (Vous)
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer ce compte définitivement ?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-600 hover:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal d'ajout (ID: modal-user) --}}
    <div id="modal-user" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
            <h3 class="text-xl font-black uppercase text-white mb-6 italic tracking-tighter">Nouveau Collaborateur</h3>
            
            <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Nom complet" required 
                           class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email professionnel" required 
                           class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Mot de passe" required 
                           class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm text-white focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('modal-user').classList.add('hidden')" 
                            class="flex-1 py-4 text-xs font-black uppercase text-slate-500 hover:text-white transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="flex-1 py-4 bg-blue-600 text-white rounded-2xl text-xs font-black uppercase shadow-lg shadow-blue-600/20 hover:bg-blue-500 transition-all">
                        Créer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Notification Toast --}}
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 3000)" 
             x-show="show" 
             class="fixed bottom-10 right-10 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl font-black uppercase text-[10px] tracking-widest z-[60]">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>