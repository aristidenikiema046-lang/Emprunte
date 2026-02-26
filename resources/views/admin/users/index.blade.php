<x-app-layout>
    <div class="p-6 bg-[#0f172a] min-h-screen text-slate-200">
        
        {{-- Header avec Statistiques --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h2 class="text-2xl font-black italic uppercase tracking-widest text-white">
                    Gestion <span class="text-blue-500">Équipe</span>
                </h2>
                <div class="flex gap-4 mt-2">
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">
                        Total : {{ $users->count() }} membres
                    </p>
                    <p class="text-[10px] text-amber-500 font-bold uppercase tracking-tighter">
                        En attente : {{ $users->where('is_active', false)->count() }}
                    </p>
                </div>
            </div>
            
            <button onclick="document.getElementById('modal-user').classList.remove('hidden')" 
                    class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-sm"></i>
                Ajouter un membre
            </button>
        </div>

        {{-- Table des Utilisateurs --}}
        <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-slate-800/50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-8 py-5">Collaborateur</th>
                            <th class="px-8 py-5">Email / Rôle</th>
                            <th class="px-8 py-5 text-center">Statut</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-800/30 transition-colors group">
                            {{-- Colonne Identité --}}
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center font-black text-white shadow-lg">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        @if($user->is_active)
                                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></div>
                                        @endif
                                    </div>
                                    <span class="font-bold text-slate-200">{{ $user->name }}</span>
                                </div>
                            </td>

                            {{-- Colonne Email & Rôle --}}
                            <td class="px-8 py-5">
                                <div class="text-sm text-slate-400 font-mono mb-1">{{ $user->email }}</div>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.updateRole', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-[9px] font-black uppercase tracking-widest {{ $user->role === 'admin' ? 'text-purple-400' : 'text-blue-400' }} hover:underline">
                                            {{ $user->role === 'admin' ? 'Administrateur' : 'Collaborateur' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 italic">Administrateur (Moi)</span>
                                @endif
                            </td>

                            {{-- Colonne Statut --}}
                            <td class="px-8 py-5 text-center">
                                @if($user->is_active)
                                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 rounded-full text-[9px] font-black uppercase">Actif</span>
                                @else
                                    <span class="px-3 py-1 bg-amber-500/10 text-amber-500 border border-amber-500/20 rounded-full text-[9px] font-black uppercase animate-pulse">En attente</span>
                                @endif
                            </td>

                            {{-- Colonne Actions --}}
                            <td class="px-8 py-5">
                                <div class="flex justify-end items-center gap-2">
                                    @if($user->id !== auth()->id())
                                        
                                        {{-- Bouton pour Accepter / Bloquer --}}
                                        <form action="{{ route('users.toggleStatus', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if(!$user->is_active)
                                                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-500 transition-all shadow-lg shadow-blue-500/20">
                                                    <i class="fa-solid fa-check"></i> Accepter
                                                </button>
                                            @else
                                                <button type="submit" title="Bloquer l'accès" class="p-2 text-slate-500 hover:text-amber-500 transition-colors">
                                                    <i class="fa-solid fa-user-slash"></i>
                                                </button>
                                            @endif
                                        </form>

                                        {{-- Bouton Supprimer --}}
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer ce compte définitivement ?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-600 hover:text-red-500 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-[10px] text-slate-600 italic">Aucune action</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal de création --}}
    <div id="modal-user" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
            <h3 class="text-xl font-black uppercase text-white mb-6 italic tracking-tighter">Nouveau Collaborateur</h3>
            
            <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nom complet" required 
                       class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm text-white focus:ring-2 focus:ring-blue-500">
                
                <input type="email" name="email" placeholder="Email professionnel" required 
                       class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm text-white focus:ring-2 focus:ring-blue-500">
                
                <input type="password" name="password" placeholder="Mot de passe" required 
                       class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm text-white focus:ring-2 focus:ring-blue-500">
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('modal-user').classList.add('hidden')" 
                            class="flex-1 py-4 text-xs font-black uppercase text-slate-500 hover:text-white transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl text-xs font-black uppercase shadow-lg shadow-blue-600/20 hover:bg-blue-500 transition-all">
                        Créer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Notifications --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" 
             class="fixed bottom-10 right-10 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl font-black uppercase text-[10px] tracking-widest z-[60]">
            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" 
             class="fixed bottom-10 right-10 bg-red-500 text-white px-6 py-4 rounded-2xl shadow-2xl font-black uppercase text-[10px] tracking-widest z-[60]">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ session('error') }}
        </div>
    @endif

</x-app-layout>