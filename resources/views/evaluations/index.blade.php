<x-app-layout>
    <div x-data="{ openModal: false, selectedEval: {} }" class="py-6 bg-[#020617] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tighter flex items-center gap-4">
                        <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
                        Performance <span class="text-blue-500">Automatisée</span>
                    </h2>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-2 ml-6 italic">
                        Mise à jour : Vendredi 18h00
                    </p>
                </div>
                
                <div class="bg-gray-900 px-6 py-3 rounded-2xl border border-white/5 shadow-xl">
                    <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Moyenne Globale</p>
                    <h3 class="text-2xl font-black text-blue-500">{{ number_format($globalAverage, 2) }} <span class="text-xs text-gray-700">/ 9</span></h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                @if(auth()->user()->role === 'admin')
                <div class="lg:col-span-4">
                    <div class="bg-gray-900 p-8 rounded-[3rem] border border-white/5 shadow-2xl sticky top-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-robot text-blue-500"></i>
                            </div>
                            <h3 class="text-white font-black uppercase text-sm">Smart Audit</h3>
                        </div>

                        <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="text-[10px] font-black text-gray-500 uppercase ml-2 italic">Collaborateur</label>
                                <select name="user_id" class="w-full bg-slate-950 border-gray-800 rounded-2xl text-sm py-4 mt-2 text-white focus:ring-2 focus:ring-blue-600" required>
                                    <option value="">Sélectionner un membre...</option>
                                    @foreach($users as $u) 
                                        <option value="{{ $u->id }}">{{ $u->name }}</option> 
                                    @endforeach
                                </select>
                            </div>

                            <div class="p-4 bg-blue-600/5 rounded-2xl border border-blue-600/10 space-y-3">
                                <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest border-b border-blue-600/10 pb-2">Paramètres de l'algorithme :</p>
                                <ul class="text-[9px] text-gray-400 font-bold space-y-2 uppercase">
                                    <li class="flex items-center gap-2"><i class="fa-solid fa-calendar-check text-blue-500"></i> Présence (Min. 3/5 jours)</li>
                                    <li class="flex items-center gap-2"><i class="fa-solid fa-list-check text-blue-500"></i> Tâches complétées</li>
                                    <li class="flex items-center gap-2"><i class="fa-solid fa-check-to-slot text-blue-500"></i> Participation Sondages</li>
                                </ul>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-600/20 transition-all flex items-center justify-center gap-3">
                                Lancer l'Analyse
                                <i class="fa-solid fa-bolt-lightning"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <div class="{{ auth()->user()->role === 'admin' ? 'lg:col-span-8' : 'lg:col-span-12' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($evaluations as $eval)
                        <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 hover:border-blue-500/30 transition-all shadow-xl group">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-950 border border-gray-800 flex items-center justify-center text-blue-500 font-black shadow-inner">
                                        {{ substr($eval->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white uppercase text-xs tracking-tight">{{ $eval->user->name }}</h4>
                                        <p class="text-[9px] text-gray-600 font-bold uppercase">{{ $eval->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <div class="text-2xl font-black text-white">{{ number_format($eval->total_score, 2) }} <span class="text-[10px] text-gray-700">/ 9</span></div>
                                    
                                    <button 
                                        @click="selectedEval = {{ json_encode([
                                            'name' => $eval->user->name,
                                            'date' => $eval->created_at->translatedFormat('d F Y'),
                                            'presence' => $eval->presence,
                                            'tasks' => $eval->reporting,
                                            'polls' => $eval->implication,
                                            'rules' => $eval->rules_respect,
                                            'total' => number_format($eval->total_score, 2)
                                        ]) }}; openModal = true"
                                        class="text-[10px] font-bold uppercase text-blue-500 hover:text-white transition-colors flex items-center gap-1 bg-blue-500/10 px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-eye"></i> Détails
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-[8px] font-black uppercase text-gray-500 mb-1">
                                        <span>Indice de Performance Hebdomadaire</span>
                                        <span class="text-blue-400">{{ number_format(($eval->total_score / 9) * 100, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-950 h-2 rounded-full overflow-hidden border border-gray-800">
                                        <div class="bg-gradient-to-r from-blue-600 to-indigo-500 h-full transition-all duration-1000" 
                                             style="width: {{ ($eval->total_score / 9) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-20 text-center bg-gray-900 rounded-[3rem] border border-dashed border-white/10">
                            <i class="fa-solid fa-magnifying-glass-chart text-4xl text-gray-800 mb-4"></i>
                            <p class="text-gray-600 font-bold uppercase text-xs tracking-[0.2em]">En attente du premier audit automatique</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0 scale-90"
             x-cloak>
            
            <div @click.away="openModal = false" class="bg-gray-900 border border-white/10 w-full max-w-lg rounded-[3rem] p-8 shadow-2xl relative">
                
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-black uppercase text-white tracking-tighter" x-text="selectedEval.name"></h3>
                        <p class="text-[10px] text-blue-500 font-bold uppercase italic" x-text="'Audit du ' + selectedEval.date"></p>
                    </div>
                    <button @click="openModal = false" class="text-gray-500 hover:text-white transition-colors">
                        <i class="fa-solid fa-circle-xmark text-2xl"></i>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-950 p-5 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2">Présence (Assiduité)</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-emerald-500" x-text="selectedEval.presence"></span>
                            <span class="text-[10px] text-gray-700">/ 4</span>
                        </div>
                    </div>

                    <div class="bg-slate-950 p-5 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2">Tâches (Sérieux)</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-blue-500" x-text="selectedEval.tasks"></span>
                            <span class="text-[10px] text-gray-700">/ 4</span>
                        </div>
                    </div>

                    <div class="bg-slate-950 p-5 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2">Sondages (Engagement)</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-purple-500" x-text="selectedEval.polls"></span>
                            <span class="text-[10px] text-gray-700">/ 4</span>
                        </div>
                    </div>

                    <div class="bg-slate-950 p-5 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2">Respect de la Règle 3/5</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-amber-500" x-text="selectedEval.rules"></span>
                            <span class="text-[10px] text-gray-700">/ 4</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 p-6 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2rem] flex justify-between items-center shadow-xl shadow-blue-600/20">
                    <span class="font-black uppercase text-xs tracking-widest">Score Final Calculé</span>
                    <div class="text-3xl font-black italic">
                        <span x-text="selectedEval.total"></span>
                        <span class="text-xs opacity-50">/ 9</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>