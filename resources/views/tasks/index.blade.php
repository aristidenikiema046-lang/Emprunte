<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black italic tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-500 uppercase">
                        Gestion des Missions
                    </h2>
                    <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold mt-1">Suivi de progression en temps réel</p>
                </div>
                
                <div class="bg-[#1e293b] p-2 rounded-2xl border border-slate-700 shadow-2xl">
                    <div class="px-4 py-2 bg-[#0f172a] rounded-xl border border-indigo-500/30 text-center">
                        <span class="block text-[9px] text-slate-500 font-black uppercase">Missions Terminées</span>
                        <span class="text-xl font-black text-indigo-400">
                            {{ $tasks->where('is_completed', true)->count() }} <span class="text-slate-600">/</span> {{ $tasks->count() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Formulaire Admin --}}
            @if(auth()->user()->isAdmin())
            <div class="relative group mb-12">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.5rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative bg-[#1e293b] p-8 rounded-[2rem] border border-slate-700 shadow-2xl">
                    <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-2">Collaborateur</label>
                            <select name="user_id" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-slate-300 focus:ring-indigo-500 py-3" required>
                                <option value="">Choisir un membre...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase ml-2">Objectif</label>
                            <input type="text" name="title" placeholder="Titre de la mission..." class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white focus:ring-indigo-500 py-3" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-3 rounded-2xl font-black text-xs uppercase transition-all shadow-lg shadow-indigo-500/20">Lancer la mission</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Liste des Tâches --}}
            <div class="grid grid-cols-1 gap-4">
                @forelse($tasks as $task)
                <div class="bg-[#1e293b] p-5 rounded-3xl border border-slate-800 transition-all shadow-xl">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                        
                        {{-- Gauche : Titre et User --}}
                        <div class="flex items-center gap-5 w-full lg:w-1/3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center border {{ $task->is_completed ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-500' : 'bg-indigo-500/10 border-indigo-500/30 text-indigo-500' }}">
                                @if($task->is_completed)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span class="font-black text-sm">{{ $task->progress }}%</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-sm {{ $task->is_completed ? 'text-slate-500 line-through' : 'text-white' }}">{{ $task->title }}</h3>
                                <span class="text-[9px] font-black text-indigo-400 uppercase tracking-tighter bg-indigo-500/5 px-2 py-0.5 rounded border border-indigo-500/10">{{ $task->user->name }}</span>
                            </div>
                        </div>

                        {{-- Milieu : Slider ou Barre --}}
                        <div class="w-full lg:flex-1">
                            @if(auth()->id() === $task->user_id && !$task->is_completed)
                                <form action="{{ route('tasks.progress', $task) }}" method="POST" class="space-y-1">
                                    @csrf @method('PATCH')
                                    <input type="range" name="progress" value="{{ $task->progress }}" min="0" max="100" step="10" onchange="this.form.submit()" class="w-full h-1.5 bg-[#0f172a] rounded-lg appearance-none cursor-pointer accent-indigo-500 border border-slate-700">
                                    <div class="flex justify-between text-[8px] font-bold text-slate-500 uppercase">
                                        <span>Avancement</span>
                                        <span>{{ $task->progress }}%</span>
                                    </div>
                                </form>
                            @else
                                <div class="space-y-1.5">
                                    <div class="h-1.5 w-full bg-[#0f172a] rounded-full overflow-hidden border border-slate-800">
                                        <div class="h-full transition-all duration-700 {{ $task->progress < 40 ? 'bg-red-500' : ($task->progress < 80 ? 'bg-orange-500' : 'bg-emerald-500') }}" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest">Statut : {{ $task->is_completed ? 'Terminé' : 'En cours' }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Droite : Bouton Toggle --}}
                        <div class="flex items-center gap-3">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-5 py-2 rounded-xl border border-slate-700 bg-slate-900 text-[9px] font-black uppercase tracking-widest hover:border-indigo-500 transition-all">
                                    {{ $task->is_completed ? 'Réouvrir' : 'Terminer' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-12 text-center bg-[#1e293b] rounded-[2rem] border-2 border-dashed border-slate-800">
                    <p class="text-slate-500 text-sm italic">Aucune mission assignée.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>