<x-app-layout>
    <div class="py-6 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- En-tête --}}
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
                
                <div class="bg-gray-900/50 p-4 rounded-2xl border border-gray-800 shadow-2xl flex items-center gap-4">
                    <div class="p-3 bg-blue-600/10 rounded-xl border border-blue-500/20">
                        <i class="fa-solid fa-gauge-high text-blue-500"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] text-gray-500 font-black uppercase tracking-widest">Complétées</span>
                        <span class="text-2xl font-black text-white">
                            {{ $tasks->where('is_completed', true)->count() }} <span class="text-gray-700 text-lg">/</span> {{ $tasks->count() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Formulaire Admin --}}
            @if(auth()->user()->role === 'admin')
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] shadow-2xl mb-12">
                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    Nouvelle Assignation
                </h3>
                <form action="{{ route('tasks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase">Collaborateur</label>
                        <select name="user_id" class="w-full bg-gray-950 border-gray-800 rounded-xl text-gray-300 focus:border-blue-500 focus:ring-0 py-3.5 text-sm" required>
                            <option value="">Choisir...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase">Mission</label>
                        <input type="text" name="title" placeholder="Description courte..." class="w-full bg-gray-950 border-gray-800 rounded-xl text-white focus:border-blue-500 focus:ring-0 py-3.5 text-sm" required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-4 rounded-xl font-black text-xs uppercase transition-all shadow-lg shadow-blue-500/20">
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
                        
                        {{-- Icone/Status --}}
                        <div class="flex items-center gap-6 w-full lg:w-1/3">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center border-2 {{ $task->is_completed ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-500' : 'bg-blue-500/10 border-blue-500/20 text-blue-500' }}">
                                @if($task->is_completed)
                                    <i class="fa-solid fa-check-double text-xl"></i>
                                @else
                                    <span class="font-black text-sm">{{ $task->progress }}%</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-base {{ $task->is_completed ? 'text-gray-600 line-through' : 'text-white' }}">{{ $task->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest bg-blue-500/5 px-2 py-0.5 rounded border border-blue-500/10">
                                        {{ $task->user?->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Progression --}}
                        <div class="w-full lg:flex-1 px-4">
                            @if(auth()->id() == $task->user_id && !$task->is_completed)
                                <div class="space-y-3">
                                    <span class="text-[9px] font-black text-gray-500 uppercase">Mettre à jour mon avancement</span>
                                    <div class="flex gap-2">
                                        @foreach([25, 50, 75, 100] as $step)
                                            <form action="{{ route('tasks.updateProgress', $task) }}" method="POST" class="flex-1">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="progress" value="{{ $step }}">
                                                <button type="submit" class="w-full py-2 rounded-xl border text-[10px] font-black transition-all {{ $task->progress == $step ? 'bg-blue-600 border-blue-500 text-white shadow-lg' : 'bg-gray-950 border-gray-800 text-gray-500 hover:text-white' }}">
                                                    {{ $step }}%
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="space-y-2">
                                    <div class="flex justify-between text-[9px] font-black uppercase">
                                        <span class="text-gray-600">Progression observée</span>
                                        <span class="{{ $task->is_completed ? 'text-emerald-500' : 'text-blue-500' }}">{{ $task->progress }}%</span>
                                    </div>
                                    <div class="h-2 w-full bg-gray-950 rounded-full border border-gray-800 p-0.5">
                                        <div class="h-full rounded-full transition-all duration-1000 {{ $task->is_completed ? 'bg-emerald-500' : 'bg-blue-600' }}" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-4">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-5 py-2.5 rounded-xl border font-black text-[10px] uppercase transition-all {{ $task->is_completed ? 'border-gray-800 bg-gray-950 text-gray-400 hover:text-white' : 'border-emerald-500/30 bg-emerald-500/5 text-emerald-500 hover:bg-emerald-500 hover:text-white' }}">
                                    {{ $task->is_completed ? 'Réactiver' : 'Clôturer' }}
                                </button>
                            </form>
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/5 border border-red-500/20 text-red-500 hover:bg-red-500 hover:text-white">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center bg-gray-900/50 rounded-[3rem] border-2 border-dashed border-gray-800 text-gray-500">
                    Aucune mission active.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>