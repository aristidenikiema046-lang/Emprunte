<x-app-layout>
    <div x-data="{ openModal: false, selectedEval: {} }" class="py-6 bg-[#020617] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($evaluations as $eval)
                <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 hover:border-blue-500/30 transition-all shadow-xl group relative">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-950 border border-gray-800 flex items-center justify-center text-blue-500 font-black">
                                {{ substr($eval->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-white uppercase text-xs">{{ $eval->user->name }}</h4>
                                <p class="text-[9px] text-gray-600 font-bold uppercase">{{ $eval->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <button 
                            @click="selectedEval = {{ json_encode([
                                'name' => $eval->user->name,
                                'date' => $eval->created_at->translatedFormat('d F Y'),
                                'score' => number_format($eval->total_score, 2),
                                'presence' => $eval->presence,
                                'reporting' => $eval->reporting,
                                'implication' => $eval->implication,
                                'rules' => $eval->rules_respect,
                                'comm' => $eval->communication
                            ]) }}; openModal = true"
                            class="p-2 bg-slate-950 rounded-xl border border-gray-800 hover:text-blue-500 transition-colors">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-[8px] font-black uppercase text-gray-500">
                            <span>Performance Globale</span>
                            <span class="text-blue-400">{{ number_format(($eval->total_score / 9) * 100, 0) }}%</span>
                        </div>
                        <div class="w-full bg-slate-950 h-1.5 rounded-full overflow-hidden border border-gray-800">
                            <div class="bg-blue-600 h-full transition-all duration-700" style="width: {{ ($eval->total_score / 9) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                    @endforelse
            </div>
        </div>

        <div x-show="openModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0"
             x-cloak>
            
            <div @click.away="openModal = false" 
                 class="bg-gray-900 border border-white/10 w-full max-w-lg rounded-[3rem] p-8 shadow-2xl relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl"></div>

                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-black uppercase text-white tracking-tighter" x-text="selectedEval.name"></h3>
                        <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest" x-text="'Audit du ' + selectedEval.date"></p>
                    </div>
                    <button @click="openModal = false" class="text-gray-500 hover:text-white">
                        <i class="fa-solid fa-circle-xmark text-2xl"></i>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-950 p-4 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2 italic">Assiduité (3/5j)</p>
                        <div class="flex items-end gap-2">
                            <span class="text-xl font-black text-emerald-500" x-text="selectedEval.presence"></span>
                            <span class="text-[10px] text-gray-700 mb-1">/ 4</span>
                        </div>
                    </div>

                    <div class="bg-slate-950 p-4 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2 italic">Reporting & Tâches</p>
                        <div class="flex items-end gap-2">
                            <span class="text-xl font-black text-blue-500" x-text="selectedEval.reporting"></span>
                            <span class="text-[10px] text-gray-700 mb-1">/ 4</span>
                        </div>
                    </div>

                    <div class="bg-slate-950 p-4 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2 italic">Sondages / Engagement</p>
                        <div class="flex items-end gap-2">
                            <span class="text-xl font-black text-purple-500" x-text="selectedEval.implication"></span>
                            <span class="text-[10px] text-gray-700 mb-1">/ 4</span>
                        </div>
                    </div>

                    <div class="bg-slate-950 p-4 rounded-3xl border border-white/5">
                        <p class="text-[8px] font-black text-gray-500 uppercase mb-2 italic">Respect des Règles</p>
                        <div class="flex items-end gap-2">
                            <span class="text-xl font-black text-amber-500" x-text="selectedEval.rules"></span>
                            <span class="text-[10px] text-gray-700 mb-1">/ 4</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 p-6 bg-blue-600 rounded-[2rem] flex justify-between items-center shadow-lg shadow-blue-600/20">
                    <span class="font-black uppercase text-xs tracking-widest text-white/80">Score Final Certifié</span>
                    <div class="text-3xl font-black text-white italic">
                        <span x-text="selectedEval.score"></span>
                        <span class="text-xs opacity-50">/ 9</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>