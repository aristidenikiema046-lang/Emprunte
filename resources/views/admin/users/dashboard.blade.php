<x-app-layout>
    <div class="py-6 space-y-8">
        {{-- Header & Notifications --}}
        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
            <div>
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Mon <span class="text-blue-600">Espace</span></h2>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest italic">Analyse de vos activités personnelles</p>
            </div>
            
            <div class="w-full md:w-80 space-y-2">
                @foreach($notifications as $note)
                <div class="p-3 bg-{{ $note['type'] }}-500/10 border border-{{ $note['type'] }}-500/20 rounded-xl flex items-center gap-3 animate-pulse">
                    <div class="w-2 h-2 rounded-full bg-{{ $note['type'] }}-500"></div>
                    <p class="text-[10px] font-black text-{{ $note['type'] }}-200 uppercase">{{ $note['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Progression Tâches --}}
            <div class="bg-gray-900 p-8 rounded-[2.5rem] border border-white/5 relative overflow-hidden group">
                <p class="text-[10px] font-black text-gray-500 uppercase mb-4">Missions Complétées</p>
                <div class="flex items-end justify-between mb-2">
                    <h3 class="text-5xl font-black text-white">{{ round($myProgress) }}%</h3>
                    <span class="text-[10px] font-bold text-blue-500 uppercase">{{ $completedMyTasks }}/{{ $totalMyTasks }}</span>
                </div>
                <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-full transition-all duration-1000 shadow-[0_0_10px_#2563eb]" style="width: {{ $myProgress }}%"></div>
                </div>
            </div>

            {{-- Présence du Jour --}}
            <div class="bg-gray-900 p-8 rounded-[2.5rem] border border-white/5">
                <p class="text-[10px] font-black text-gray-500 uppercase mb-4">Statut Présence</p>
                @if($myAttendanceToday)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                            <i class="fa-solid fa-check-double text-xl"></i>
                        </div>
                        <div>
                            <p class="text-white font-black uppercase text-sm">Pointage Effectué</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">Arrivée : {{ $myAttendanceToday->check_in_8h30 ? $myAttendanceToday->check_in_8h30->format('H:i') : '--:--' }}</p>
                        </div>
                    </div>
                @else
                    <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all">
                            <i class="fa-solid fa-fingerprint text-xl"></i>
                        </div>
                        <p class="text-gray-400 font-black uppercase text-xs group-hover:text-white transition-all">Pointer maintenant</p>
                    </a>
                @endif
            </div>

            {{-- Note Performance --}}
            <div class="bg-gray-900 p-8 rounded-[2.5rem] border border-white/5 relative group">
                <p class="text-[10px] font-black text-gray-500 uppercase mb-4">Dernière Évaluation</p>
                <div class="flex items-baseline gap-1">
                    <h3 class="text-5xl font-black text-amber-500">{{ $lastEval ? number_format($lastEval->total_score, 1) : 'N/A' }}</h3>
                    <span class="text-gray-600 font-black text-sm">/ 9</span>
                </div>
                <i class="fa-solid fa-award absolute right-8 top-8 text-3xl text-gray-800 group-hover:text-amber-500/20 transition-all"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Missions en cours --}}
            <div class="lg:col-span-8 bg-gray-900 p-8 rounded-[3rem] border border-white/5">
                <h3 class="text-white font-black uppercase text-sm mb-6 flex items-center gap-2 italic">
                    <span class="w-1 h-4 bg-blue-600 rounded-full"></span> Mes Missions Actuelles
                </h3>
                <div class="space-y-4">
                    @forelse($myTasks as $task)
                    <div class="flex items-center justify-between p-4 bg-slate-950/50 rounded-2xl border border-white/5 group hover:border-blue-500/30 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-gray-900 rounded-xl text-blue-500">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-white uppercase">{{ $task->title }}</p>
                                <p class="text-[9px] text-gray-500 font-bold uppercase">{{ $task->priority }} priorité</p>
                            </div>
                        </div>
                        <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-900 text-[9px] font-black text-gray-400 rounded-xl hover:bg-blue-600 hover:text-white transition-all uppercase">Ouvrir</a>
                    </div>
                    @empty
                    <p class="text-center py-10 text-gray-600 text-xs font-black uppercase italic">Aucune mission en cours</p>
                    @endforelse
                </div>
            </div>

            {{-- Widget Profil --}}
            <div class="lg:col-span-4 bg-blue-600 p-8 rounded-[3rem] text-white shadow-2xl shadow-blue-600/20 relative overflow-hidden">
                <div class="relative z-10">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fff&color=2563eb' }}" class="w-20 h-20 rounded-2xl mb-4 border-2 border-white/20">
                    <h4 class="text-xl font-black uppercase">{{ Auth::user()->name }}</h4>
                    <p class="text-[10px] font-bold uppercase opacity-70 mb-4 italic">{{ Auth::user()->post }}</p>
                    <div class="space-y-2 border-t border-white/10 pt-4">
                        <p class="text-[9px] font-black uppercase tracking-widest"><i class="fa-solid fa-id-card mr-2"></i> {{ Auth::user()->employee_id }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest"><i class="fa-solid fa-sitemap mr-2"></i> {{ Auth::user()->department }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>