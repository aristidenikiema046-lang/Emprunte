<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- En-tête --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black italic tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-500 uppercase">
                        Suivi des Missions
                    </h2>
                    <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold mt-1">Pilotage en temps réel</p>
                </div>
                
                <div class="bg-[#1e293b] p-2 rounded-2xl border border-slate-700 shadow-2xl text-center min-w-[150px]">
                    <span class="block text-[9px] text-slate-500 font-black uppercase">Complétion</span>
                    <span class="text-xl font-black text-indigo-400">
                        {{ $tasks->where('is_completed', true)->count() }} <span class="text-slate-600">/</span> {{ $tasks->count() }}
                    </span>
                </div>
            </div>

            {{-- Assignation Admin --}}
            @if(auth()->user()->role === 'admin')
            <div class="bg-[#1e293b] p-6 rounded-[2rem] border border-slate-700 shadow-2xl mb-10">
                <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase ml-2">Collaborateur</label>
                        <select name="user_id" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-slate-300 focus:ring-indigo-500 py-3 text-sm" required>
                            <option value="">Sélectionner...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase ml-2">Mission</label>
                        <input type="text" name="title" placeholder="Ex: Inventaire stock..." class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white focus:ring-indigo-500 py-3 text-sm" required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-3 rounded-2xl font-black text-xs uppercase transition-all shadow-lg shadow-indigo-500/20">Assigner</button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Liste des Missions --}}
            <div class="grid grid-cols-1 gap-4">
                @forelse($tasks as $task)
                <div class="bg-[#1e293b] p-5 rounded-3xl border border-slate-800 transition-all hover:border-slate-700 shadow-xl">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                        
                        {{-- Infos Mission (CORRIGÉ ICI) --}}
                        <div class="flex items-center gap-5 w-full lg:w-1/3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center border {{ $task->is_completed ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-500' : 'bg-indigo-500/10 border-indigo-500/30 text-indigo-500' }}">
                                @if($task->is_completed)
                                    <i class="fa-solid fa-check text-lg"></i>
                                @else
                                    <span class="font-black text-xs">{{ $task->progress ?? 0 }}%</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-sm {{ $task->is_completed ? 'text-slate-500 line-through' : 'text-white' }}">{{ $task->title }}</h3>
                                {{-- Utilisation de ?-> pour éviter l'erreur si l'user est nul --}}
                                <span class="text-[9px] font-black text-indigo-400 uppercase tracking-tighter">
                                    {{ $task->user?->name ?? 'Ancien membre' }}
                                </span>
                            </div>
                        </div>

                        {{-- Progression interactive ou visuelle --}}
                        <div class="w-full lg:flex-1">
                            @if(auth()->id() === $task->user_id && !$task->is_completed)
                                <div class="space-y-3">
                                    <div class="flex gap-2">
                                        @foreach([25, 50, 75, 100] as $step)
                                            <form action="{{ route('tasks.progress', $task) }}" method="POST" class="flex-1">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="progress" value="{{ $step }}">
                                                <button type="submit" class="w-full py-1.5 rounded-lg border {{ ($task->progress ?? 0) == $step ? 'bg-indigo-600 border-indigo-500' : 'bg-[#0f172a] border-slate-700 text-slate-500 hover:text-white' }} text-[9px] font-black transition-all">
                                                    {{ $step }}%
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                    <div class="h-1.5 w-full bg-[#0f172a] rounded-full overflow-hidden border border-slate-800">
                                        <div class="h-full bg-indigo-500 transition-all duration-500" style="width: {{ $task->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-1.5 text-right">
                                    <div class="h-2 w-full bg-[#0f172a] rounded-full overflow-hidden border border-slate-800 shadow-inner">
                                        <div class="h-full transition-all duration-700 {{ ($task->progress ?? 0) < 40 ? 'bg-red-500' : (($task->progress ?? 0) < 80 ? 'bg-orange-500' : 'bg-emerald-500') }}" style="width: {{ $task->progress ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">{{ $task->is_completed ? 'Terminé' : 'En cours ('.($task->progress ?? 0).'%)' }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Action Rapide --}}
                        <div class="flex items-center gap-3">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-4 py-2 rounded-xl border border-slate-700 bg-slate-900 text-[9px] font-black uppercase hover:border-indigo-500 transition-all">
                                    {{ $task->is_completed ? 'Rouvrir' : 'Terminer' }}
                                </button>
                            </form>

                            {{-- Option de suppression pour l'Admin --}}
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette mission ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-500 transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-12 text-center bg-[#1e293b] rounded-[2rem] border-2 border-dashed border-slate-800">
                    <p class="text-slate-500 text-sm italic font-bold">Aucune mission en cours.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>