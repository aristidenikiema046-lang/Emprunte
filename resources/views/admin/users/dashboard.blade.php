<x-app-layout>
    <div class="p-6 bg-[#0f172a] min-h-screen text-slate-200">
        
        {{-- Header Personnel --}}
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </div>
                <h2 class="text-2xl font-black uppercase tracking-widest text-white">Mon Espace <span class="text-blue-500">Collaborateur</span></h2>
            </div>
            <div class="text-xs font-mono text-slate-500 bg-slate-900 px-4 py-2 rounded-full border border-slate-800">
                {{ now()->translatedFormat('l d F Y') }}
            </div>
        </div>

        {{-- Stats Personnelles --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Progression --}}
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem]">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Ma Progression Moyenne</p>
                <span class="text-5xl font-black text-white">{{ $myProgress }}%</span>
                <div class="w-full bg-slate-800 h-1.5 rounded-full mt-6">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-1.5 rounded-full transition-all" style="width: {{ $myProgress }}%"></div>
                </div>
            </div>

            {{-- Tâches --}}
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem]">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Mes Missions en cours</p>
                <div class="flex items-center justify-between">
                    <span class="text-5xl font-black text-white">{{ $myTasks->count() }}</span>
                    <div class="p-3 bg-blue-500/10 rounded-2xl">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Pointage --}}
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem]">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Pointage du jour</p>
                @if($myAttendanceToday)
                    <div class="flex flex-col">
                        <span class="text-emerald-500 font-black uppercase text-sm flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Présent
                        </span>
                        <span class="text-[10px] text-slate-500 mt-1">Arrivée à : {{ \Carbon\Carbon::parse($myAttendanceToday->check_in)->format('H:i') }}</span>
                    </div>
                @else
                    <span class="text-amber-500 font-black uppercase text-sm flex items-center gap-2">
                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span> En attente
                    </span>
                @endif
            </div>
        </div>

        {{-- Liste de MES Missions --}}
        <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
            <h3 class="text-xs font-black uppercase text-slate-400 mb-6 flex items-center">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Mes objectifs prioritaires
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($myTasks as $mission)
                <div class="flex items-center justify-between p-4 bg-slate-800/20 rounded-2xl border border-slate-800/50 hover:border-blue-500/50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="text-xs font-black text-blue-500 bg-blue-500/10 w-10 h-10 rounded-xl flex items-center justify-center">
                            {{ $mission->progress }}%
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ $mission->title }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest">Priorité : {{ $mission->priority }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="text-[8px] font-black uppercase px-2 py-1 rounded bg-slate-900 border {{ $mission->priority == 'haute' ? 'text-red-500 border-red-900' : 'text-slate-500 border-slate-800' }}">
                            {{ $mission->priority }}
                        </span>
                    </div>
                </div>
                @empty
                    <div class="col-span-2 py-10 text-center">
                        <p class="text-slate-600 text-xs italic">Aucune mission ne vous a été assignée pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>