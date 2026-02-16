<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black italic tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-500">
                        GESTION DES MISSIONS
                    </h2>
                    <p class="text-slate-500 text-xs uppercase tracking-widest font-bold mt-1">Suivi de progression en temps réel</p>
                </div>
                
                <div class="flex items-center gap-3 bg-[#1e293b] p-2 rounded-2xl border border-slate-700 shadow-2xl">
                    <div class="px-4 py-2 bg-[#0f172a] rounded-xl border border-indigo-500/30">
                        <span class="block text-[10px] text-slate-500 font-black uppercase">Taux de complétion</span>
                        <span class="text-xl font-black text-indigo-400">
                            {{ $tasks->where('is_completed', true)->count() }}
                            <span class="text-slate-600 mx-1">/</span>
                            {{ $tasks->count() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Formulaire d'assignation (Uniquement pour l'Admin) --}}
            @if(auth()->user()->isAdmin())
            <div class="relative group mb-12">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                <div class="relative bg-[#1e293b] p-8 rounded-[2rem] border border-slate-700 shadow-2xl">
                    <h3 class="text-lg font-bold mb-6 italic flex items-center gap-2">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                        Nouvelle assignation
                    </h3>
                    <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-2">Collaborateur cible</label>
                            <select name="user_id" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-slate-300 focus:ring-2 focus:ring-indigo-500 py-3" required>
                                <option value="">Choisir un membre...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-2">Intitulé de l'objectif</label>
                            <input type="text" name="title" placeholder="Ex: Inventaire stock A..." class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500 py-3" required>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-3 rounded-2xl font-black text-sm uppercase transition-all shadow-lg shadow-indigo-500/20">
                                Lancer la mission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Liste des Tâches --}}
            <div class="grid grid-cols-1 gap-6">
                @forelse($tasks as $task)
                <div class="group relative bg-[#1e293b] p-6 rounded-3xl border border-slate-800 hover:border-slate-600 transition-all shadow-xl">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                        
                        {{-- Infos de la tâche --}}
                        <div class="flex items-center gap-6 w-full lg:w-1/3">
                            <div class="w-14 h-14 rounded-2xl {{ $task->is_completed ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-indigo-500/10 border-indigo-500/20' }} border flex items-center justify-center">
                                @if($task->is_completed)
                                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span class="text-indigo-500 font-black text-xl">{{ $task->progress }}%</span>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-lg font-bold {{ $task->is_completed ? 'text-slate-500 line-through' : 'text-white' }}">
                                    {{ $task->title }}
                                </h3>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-tighter bg-indigo-500/5 px-2 py-0.5 rounded border border-indigo-500/10">
                                        {{ $task->user->name }}
                                    </span>
                                    <span class="text-slate-500 text-[10px] uppercase font-bold">{{ $task->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Le Slider de Progression (Actif seulement pour le propriétaire) --}}
                        <div class="w-full lg:flex-1 px-4">
                            @if(auth()->id() === $task->user_id && !$task->is_completed)
                                <form action="{{ route('tasks.progress', $task) }}" method="POST" class="space-y-2">
                                    @csrf @method('PATCH')
                                    <div class="flex justify-between text-[10px] font-black uppercase text-slate-500">
                                        <span>Glisser pour progresser</span>
                                        <span class="text-indigo-400 italic">Relâcher pour sauvegarder</span>
                                    </div>
                                    <input type="range" name="progress" value="{{ $task->progress }}" min="0" max="100" step="10"
                                           onchange="this.form.submit()"
                                           class="w-full h-2 bg-[#0f172a] rounded-lg appearance-none cursor-pointer accent-indigo-500 border border-slate-700 shadow-inner">
                                </form>
                            @else
                                {{-- Simple barre de lecture si c'est l'admin qui regarde ou si c'est fini --}}
                                <div class="space-y-2">
                                    <div class="h-2 w-full bg-[#0f172a] rounded-full overflow-hidden border border-slate-800">
                                        <div class="h-full {{ $task->is_completed ? 'bg-emerald-500' : 'bg-indigo-500 animate-pulse' }}" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Progression actuelle : {{ $task->progress }}%</span>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-6 py-2 rounded-xl border {{ $task->is_completed ? 'border-emerald-500/50 bg-emerald-500/10 text-emerald-400' : 'border-slate-700 bg-slate-900 text-slate-400 hover:border-indigo-500 hover:text-indigo-400' }} font-black text-[10px] uppercase tracking-widest transition-all">
                                    {{ $task->is_completed ? 'Réouvrir' : 'Terminer' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center bg-[#1e293b] rounded-[3rem] border-2 border-dashed border-slate-800">
                    <p class="text-slate-500 italic font-bold text-lg">Aucune mission en cours dans l'officine.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>