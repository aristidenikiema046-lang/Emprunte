<x-app-layout>
    <div class="py-6 space-y-10">
        
        {{-- HEADER : VISION GLOBALE --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h2 class="text-4xl font-black text-white uppercase tracking-tighter">Console <span class="text-blue-600">Admin</span></h2>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest mt-2 flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    Surveillance de l'entreprise en temps réel
                </p>
            </div>
            <div class="text-right">
                <p class="text-white font-black text-xl uppercase italic">{{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-blue-500 text-[10px] font-bold uppercase tracking-widest">Opérationnel</p>
            </div>
        </div>

        {{-- STATS GÉNÉRALES (INDICATEURS CLÉS) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Effectif --}}
            <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Collaborateurs</p>
                <h3 class="text-5xl font-black text-white group-hover:text-blue-500 transition-colors">{{ $totalUsers }}</h3>
                <i class="fa-solid fa-users absolute -right-4 -bottom-4 text-6xl text-white/5 rotate-12"></i>
            </div>

            {{-- Présences Jour --}}
            <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Présents / Jour</p>
                <h3 class="text-5xl font-black text-emerald-500">{{ $attendanceToday }}</h3>
                <p class="text-[9px] font-bold text-gray-600 uppercase mt-2">Taux : {{ round(($attendanceToday / ($totalUsers ?: 1)) * 100) }}%</p>
                <i class="fa-solid fa-id-badge absolute -right-4 -bottom-4 text-6xl text-white/5 rotate-12"></i>
            </div>

            {{-- Congés en attente --}}
            <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Demandes Congés</p>
                <h3 class="text-5xl font-black {{ $pendingLeaves > 0 ? 'text-orange-500' : 'text-white' }}">{{ $pendingLeaves }}</h3>
                <a href="{{ route('leaves.index') }}" class="text-[9px] font-bold text-blue-500 uppercase hover:underline mt-2 block">Gérer les demandes</a>
            </div>

            {{-- Performance Globale --}}
            <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 shadow-2xl relative overflow-hidden group border-b-4 border-b-blue-600">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4">Performance Moyenne</p>
                <h3 class="text-5xl font-black text-white">{{ number_format($globalPerformance, 1) }}<span class="text-sm text-gray-600">/9</span></h3>
                <div class="w-full bg-gray-800 h-1 mt-4 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-full" style="width: {{ ($globalPerformance/9)*100 }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- TABLEAU DE SURVEILLANCE DES EMPLOYÉS --}}
            <div class="lg:col-span-8 bg-gray-900 rounded-[3rem] border border-white/5 overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-white font-black uppercase text-sm tracking-widest italic">Statut des équipes (Aujourd'hui)</h3>
                    <span class="px-4 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-black rounded-full border border-emerald-500/20">LIVE</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950/50">
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase">Employé</th>
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase">Département</th>
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase text-center">Présence</th>
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $emp)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=1e293b&color=fff" class="w-8 h-8 rounded-lg grayscale group-hover:grayscale-0 transition-all">
                                        <span class="text-xs font-black text-white uppercase">{{ $emp->name }}</span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $emp->department ?? 'N/A' }}</span>
                                </td>
                                <td class="p-6 text-center">
                                    @if($emp->attendances->isNotEmpty())
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[9px] font-black rounded-lg border border-emerald-500/20 uppercase">Présent</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/10 text-red-500 text-[9px] font-black rounded-lg border border-red-500/20 uppercase">Absent</span>
                                    @endif
                                </td>
                                <td class="p-6 text-right">
                                    <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-blue-500 transition-colors">
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FLUX D'ACTIVITÉ RÉCENTE --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-slate-950 p-8 rounded-[3rem] border border-white/5 shadow-2xl">
                    <h3 class="text-white font-black uppercase text-sm tracking-widest mb-8 italic">Missions Récentes</h3>
                    <div class="space-y-6">
                        @forelse($recentMissions as $mission)
                        <div class="relative pl-6 border-l border-blue-600/30 group">
                            <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-blue-600 shadow-[0_0_10px_#2563eb]"></div>
                            <p class="text-[10px] font-black text-blue-500 uppercase mb-1">{{ $mission->user->name }}</p>
                            <p class="text-xs font-bold text-gray-300 leading-tight group-hover:text-white transition-colors">{{ $mission->title }}</p>
                            <p class="text-[9px] text-gray-600 font-bold mt-1 uppercase italic">{{ $mission->updated_at->diffForHumans() }}</p>
                        </div>
                        @empty
                        <p class="text-gray-600 text-[10px] uppercase font-black text-center italic">Aucune activité</p>
                        @endforelse
                    </div>

                    <a href="{{ route('tasks.index') }}" class="w-full mt-10 block text-center py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-xl shadow-blue-600/20">
                        Voir toutes les tâches
                    </a>
                </div>

                {{-- QUICK LINKS ADMIN --}}
                <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 grid grid-cols-2 gap-4">
                    <a href="{{ route('payroll.index') }}" class="p-4 bg-slate-950 rounded-2xl border border-white/5 hover:border-blue-500/50 transition-all text-center group">
                        <i class="fa-solid fa-file-invoice-dollar text-gray-600 group-hover:text-blue-500 mb-2 block"></i>
                        <span class="text-[8px] font-black text-gray-500 uppercase tracking-tighter">Générer Paie</span>
                    </a>
                    <a href="{{ url('/evaluations') }}" class="p-4 bg-slate-950 rounded-2xl border border-white/5 hover:border-blue-500/50 transition-all text-center group">
                        <i class="fa-solid fa-star text-gray-600 group-hover:text-blue-500 mb-2 block"></i>
                        <span class="text-[8px] font-black text-gray-500 uppercase tracking-tighter">Évaluations</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>