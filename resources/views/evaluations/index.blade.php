<x-app-layout>
    <div class="py-6 bg-[#020617] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-10 flex items-center gap-4">
                <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
                Performance <span class="text-blue-500">& Évaluations</span>
            </h2>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Moyenne {{ auth()->user()->role === 'admin' ? 'Entreprise' : 'Personnelle' }}</p>
                    <h3 class="text-4xl font-black text-blue-500 mt-2">{{ number_format($globalAverage, 2) }} <span class="text-lg text-gray-700">/ 9</span></h3>
                </div>

                <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Taux de Performance</p>
                    <h3 class="text-4xl font-black text-emerald-500">{{ number_format(($globalAverage / 9) * 100, 1) }}%</h3>
                    <div class="w-full bg-gray-800 h-2 rounded-full mt-4 overflow-hidden">
                        <div class="bg-emerald-500 h-full transition-all duration-1000" style="width: {{ ($globalAverage / 9) * 100 }}%"></div>
                    </div>
                </div>

                <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Total Évaluations</p>
                        <h3 class="text-4xl font-black text-white mt-2">{{ $totalEvals }}</h3>
                    </div>
                    <i class="fa-solid fa-file-signature text-3xl text-gray-800"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- FORMULAIRE AUTOMATISÉ (ADMIN SEULEMENT) --}}
                @if(auth()->user()->role === 'admin')
                <div class="lg:col-span-5">
                    <div class="bg-gray-900 p-8 rounded-[3rem] border border-white/5 shadow-2xl sticky top-6">
                        <h3 class="text-blue-500 font-black uppercase text-xs mb-8 tracking-widest">Nouvelle Évaluation Auto</h3>

                        <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="text-[10px] font-black text-gray-500 uppercase ml-2">Collaborateur</label>
                                <select name="user_id" class="w-full bg-slate-950 border-none rounded-2xl text-sm py-4 mt-2 text-white focus:ring-2 focus:ring-blue-600" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($users as $u) <option value="{{ $u->id }}">{{ $u->name }}</option> @endforeach
                                </select>
                            </div>

                            @php
                                $criteres = [
                                    'problem_solving' => 'Résolution de problèmes',
                                    'reporting' => 'Qualité du Reporting',
                                    'pressure_management' => 'Gestion de la pression',
                                    'communication' => 'Communication',
                                    'schedule_respect' => 'Respect des horaires',
                                    'rules_respect' => 'Respect des règles',
                                ];
                            @endphp

                            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($criteres as $key => $label)
                                <div class="p-4 bg-slate-950/50 rounded-2xl border border-white/5">
                                    <label class="text-[10px] font-black text-gray-400 uppercase mb-3 block">{{ $label }}</label>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach([1 => 'INS', 2 => 'MOY', 3 => 'BIEN', 4 => 'EXC'] as $val => $text)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="{{ $key }}" value="{{ $val }}" class="hidden peer" required>
                                            <div class="text-[9px] text-center p-2 rounded-xl bg-gray-900 text-gray-600 border border-white/5 peer-checked:bg-blue-600 peer-checked:text-white transition-all font-black">
                                                {{ $text }}
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                                {{-- Champs cachés avec valeurs par défaut pour les petits critères --}}
                                <input type="hidden" name="goals_respect" value="3">
                                <input type="hidden" name="implication" value="3">
                                <input type="hidden" name="presence" value="4">
                                <input type="hidden" name="collaboration" value="3">
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-blue-600/20 transition-all">
                                Calculer & Enregistrer
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                {{-- HISTORIQUE --}}
                <div class="{{ auth()->user()->role === 'admin' ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                    <div class="space-y-4">
                        @forelse($evaluations as $eval)
                        <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 hover:border-blue-500/30 transition-all shadow-xl">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-600/10 flex items-center justify-center text-blue-500 font-black">
                                        {{ substr($eval->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white uppercase text-sm">{{ $eval->user->name }}</h4>
                                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">{{ $eval->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-white">{{ number_format($eval->total_score, 2) }}</span>
                                    <span class="text-[10px] text-gray-600 font-bold">/ 9</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-20 bg-gray-900 rounded-[3rem] border border-dashed border-white/5">
                            <i class="fa-solid fa-inbox text-4xl text-gray-800 mb-4"></i>
                            <p class="text-gray-600 font-bold uppercase text-xs tracking-widest">Aucune donnée disponible</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>