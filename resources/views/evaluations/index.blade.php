<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-black uppercase tracking-widest mb-10 text-center lg:text-left">
                Performance <span class="text-blue-500">& Évaluations</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-slate-900/80 p-6 rounded-[2rem] border border-slate-800 shadow-xl flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Moyenne {{ auth()->user()->role === 'admin' ? 'Entreprise' : 'Personnelle' }}</p>
                        <h3 class="text-4xl font-black text-blue-500">{{ number_format($globalAverage, 2) }} <span class="text-lg text-slate-600">/ 9</span></h3>
                    </div>
                    <div class="h-14 w-14 bg-blue-500/10 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>

                <div class="bg-slate-900/80 p-6 rounded-[2rem] border border-slate-800 shadow-xl">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Taux de Performance</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-4xl font-black text-emerald-500">{{ number_format(($globalAverage / 9) * 100, 1) }}%</h3>
                        <span class="text-[10px] text-slate-400 pb-1">Objectif: 100%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full mt-3 overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ ($globalAverage / 9) * 100 }}%"></div>
                    </div>
                </div>

                <div class="bg-slate-900/80 p-6 rounded-[2rem] border border-slate-800 shadow-xl flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total Évaluations</p>
                        <h3 class="text-4xl font-black text-white">{{ $totalEvals }}</h3>
                    </div>
                    <div class="h-14 w-14 bg-slate-800 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- SECTION FORMULAIRE --}}
                @if(auth()->user()->role === 'admin')
                <div class="lg:col-span-5">
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] border border-slate-800 shadow-2xl sticky top-6">
                        <h3 class="text-blue-400 font-black uppercase text-sm mb-8 flex items-center">
                            <span class="w-8 h-px bg-blue-400 mr-3"></span> Noter un collaborateur
                        </h3>

                        <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider ml-2">Collaborateur</label>
                                <select name="user_id" class="w-full bg-slate-800 border-none rounded-2xl text-sm py-4 focus:ring-2 focus:ring-blue-500 transition-all text-white" required>
                                    <option value="">Choisir un membre de l'équipe</option>
                                    @foreach($users as $u) <option value="{{ $u->id }}">{{ $u->name }}</option> @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Résolution (max 2)</label>
                                    <input type="number" step="0.25" min="0" max="2" name="problem_solving" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Objectifs (max 0.5)</label>
                                    <input type="number" step="0.05" min="0" max="0.5" name="goals_respect" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Sous Pression (max 1)</label>
                                    <input type="number" step="0.25" min="0" max="1" name="pressure_management" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Implication (max 0.5)</label>
                                    <input type="number" step="0.05" min="0" max="0.5" name="implication" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Règles (max 1)</label>
                                    <input type="number" step="0.25" min="0" max="1" name="rules_respect" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Horaires (max 0.75)</label>
                                    <input type="number" step="0.05" min="0" max="0.75" name="schedule_respect" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Présence (max 0.25)</label>
                                    <input type="number" step="0.05" min="0" max="0.25" name="presence" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Collaboration (max 0.25)</label>
                                    <input type="number" step="0.05" min="0" max="0.25" name="collaboration" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Comm. (max 0.75)</label>
                                    <input type="number" step="0.05" min="0" max="0.75" name="communication" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase">Reporting (max 2)</label>
                                    <input type="number" step="0.25" min="0" max="2" name="reporting" class="w-full bg-slate-800 border-none rounded-xl text-sm text-white" required>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 py-4 rounded-2xl font-black uppercase text-xs shadow-lg shadow-blue-600/20 transition-all mt-4">
                                Valider l'évaluation
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                {{-- SECTION HISTORIQUE --}}
                <div class="{{ auth()->user()->role === 'admin' ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($evaluations as $eval)
                        <div class="bg-slate-900 p-6 rounded-[2rem] border-l-4 border-blue-500 shadow-xl group hover:bg-slate-800 transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">{{ $eval->created_at->format('d M Y') }}</p>
                                    <h4 class="font-black text-xl text-white group-hover:text-blue-400 transition-colors">{{ $eval->user->name }}</h4>
                                </div>
                                <div class="bg-slate-800 px-4 py-2 rounded-2xl border border-slate-700">
                                    <span class="text-2xl font-black text-blue-500">{{ number_format($eval->total_score, 2) }}</span>
                                    <span class="text-[10px] text-slate-500">/ 9</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-y-2 gap-x-4 pt-4 border-t border-slate-800">
                                <div class="flex justify-between items-center"><span class="text-[9px] text-slate-500 uppercase">Résolution:</span><span class="text-xs font-bold text-white">{{ $eval->problem_solving }}</span></div>
                                <div class="flex justify-between items-center"><span class="text-[9px] text-slate-500 uppercase">Reporting:</span><span class="text-xs font-bold text-white">{{ $eval->reporting }}</span></div>
                                <div class="flex justify-between items-center"><span class="text-[9px] text-slate-500 uppercase">Objectifs:</span><span class="text-xs font-bold text-white">{{ $eval->goals_respect }}</span></div>
                                <div class="flex justify-between items-center"><span class="text-[9px] text-slate-500 uppercase">Comm:</span><span class="text-xs font-bold text-white">{{ $eval->communication }}</span></div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full p-12 text-center bg-slate-900/50 rounded-[2.5rem] border border-dashed border-slate-800">
                            <p class="text-slate-500 font-medium italic">Aucune évaluation enregistrée pour le moment.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>