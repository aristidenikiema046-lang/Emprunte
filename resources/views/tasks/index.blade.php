<x-app-layout>
    <div class="py-6 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- En-tête Style Dashboard --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-list-check text-blue-500 text-xs"></i>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">Opérations</span>
                    </div>
                    <h2 class="text-4xl font-black italic tracking-tighter text-white uppercase">
                        Suivi des <span class="text-blue-600">Missions</span>
                    </h2>
                </div>
                
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-gray-800 shadow-2xl flex items-center gap-4 min-w-[200px]">
                    <div class="p-3 bg-blue-600/10 rounded-xl border border-blue-500/20">
                        <i class="fa-solid fa-gauge-high text-blue-500"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] text-gray-500 font-black uppercase tracking-widest">Productivité</span>
                        <span class="text-2xl font-black text-white">
                            {{ $tasks->where('is_completed', true)->count() }} <span class="text-gray-700 text-lg">/</span> {{ $tasks->count() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Assignation Admin - Style Glassmorphism --}}
            @if(auth()->user()->role === 'admin')
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] shadow-2xl mb-12 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <i class="fa-solid fa-plus-circle text-8xl text-blue-500"></i>
                </div>
                
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    Nouvelle Assignation
                </h3>

                <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase ml-1">Collaborateur cible</label>
                        <select name="user_id" class="w-full bg-gray-950 border-gray-800 rounded-xl text-gray-300 focus:border-blue-500 focus:ring-0 py-3.5 text-sm transition-all" required>
                            <option value="">Choisir un membre...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase ml-1">Intitulé de la mission</label>
                        <input type="text" name="title" placeholder="Description courte..." class="w-full bg-gray-950 border-gray-800 rounded-xl text-white focus:border-blue-500 focus:ring-0 py-3.5 text-sm transition-all" required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-4 rounded-xl font-black text-xs uppercase transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                            Lancer la mission
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Liste des Missions --}}
            <div class="space-y-4">
                @forelse($tasks as $task)
                <div class="group bg-gray-900/40 p-1 rounded-[2rem] border border-gray-800/50 hover:border-blue-500/50 transition-all duration-500">
                    <div class="bg-gray-900 p-6 rounded-[1.9rem] flex flex-col lg:flex-row justify-between items-center gap-8">
                        
                        {{-- Identité Mission --}}
                        <div class="flex items-center gap-6 w-full lg:w-1/3">
                            <div class="relative">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center border-2 transition-transform group-hover:scale-110 duration-500 {{ $task->is_completed ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-500' : 'bg-blue-500/10 border-blue-500/20 text-blue-500' }}">
                                    @if($task->is_completed)
                                        <i class="fa-solid fa-check-double text-xl"></i>
                                    @else
                                        <span class="font-black text-sm">{{ $task->progress ?? 0 }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-base {{ $task->is_completed ? 'text-gray-600 line-through' : 'text-white' }}">
                                    {{ $task->title }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest bg-blue-500/5 px-2 py-0.5 rounded border border-blue-500/10">
                                        {{ $task->user?->name ?? 'Ancien membre' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Barre de Progression Interactive --}}
                        <div class="w-full lg:flex-1 px-4">
                            @if(auth()->id() === $task->user_id && !$task->is_completed)
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center px-1">
                                        <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Mise à jour progression</span>
                                    </div>
                                    <div class="flex gap-2">
                                        @foreach([25, 50, 75, 100] as $step)
                                            <form action="{{ route('tasks.progress', $task) }}" method="POST" class="flex-1">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="progress" value="{{ $step }}">
                                                <button type="submit" class="w-full py-2 rounded-xl border transition-all text-[10px] font-black {{ ($task->progress ?? 0) == $step ? 'bg-blue-600 border-blue-500 text-white shadow-lg shadow-blue-500/20' : 'bg-gray-950 border-gray-800 text-gray-500 hover:text-white hover:border-gray-600' }}">
                                                    {{ $step }}%
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="space-y-3">
                                    <div class="flex justify-between text-[9px] font-black uppercase tracking-widest mb-1">
                                        <span class="text-gray-600">Status</span>
                                        <span class="{{ $task->is_completed ? 'text-emerald-500' : 'text-blue-500' }}">
                                            {{ $task->is_completed ? 'Mission accomplie' : 'En cours de déploiement' }}
                                        </span>
                                    </div>
                                    <div class="h-2.5 w-full bg-gray-950 rounded-full border border-gray-800 p-0.5 shadow-inner">
                                        <div class="h-full rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(59,130,246,0.5)] {{ $task->is_completed ? 'bg-emerald-500' : 'bg-blue-600' }}" 
                                             style="width: {{ $task->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions Rapides --}}
                        <div class="flex items-center gap-4">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="group/btn flex items-center gap-2 px-5 py-2.5 rounded-xl border font-black text-[10px] uppercase transition-all {{ $task->is_completed ? 'border-gray-800 bg-gray-950 text-gray-400 hover:text-white hover:border-blue-500' : 'border-emerald-500/30 bg-emerald-500/5 text-emerald-500 hover:bg-emerald-500 hover:text-white' }}">
                                    <i class="fa-solid {{ $task->is_completed ? 'fa-rotate-left' : 'fa-check' }}"></i>
                                    {{ $task->is_completed ? 'Réactiver' : 'Clôturer' }}
                                </button>
                            </form>

                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/5 border border-red-500/20 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center bg-gray-900/50 rounded-[3rem] border-2 border-dashed border-gray-800">
                    <div class="w-20 h-20 bg-gray-950 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-800">
                        <i class="fa-solid fa-clipboard-list text-gray-700 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg font-bold tracking-tight">Le tableau de bord est vide.</p>
                    <p class="text-gray-700 text-xs uppercase font-black mt-2 tracking-widest">Aucune mission n'a été assignée pour le moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>