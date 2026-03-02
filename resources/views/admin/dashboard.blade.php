<x-app-layout>
    <div class="p-6 bg-[#0f172a] min-h-screen text-slate-200">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </div>
                <h2 class="text-2xl font-black uppercase tracking-widest text-white">Dashboard <span class="text-blue-500">Monitoring</span></h2>
            </div>
            <div class="text-xs font-mono text-slate-500 bg-slate-900 px-4 py-2 rounded-full border border-slate-800">
                Live Status : {{ now()->format('H:i') }}
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem]">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Progression Globale</p>
                <span class="text-5xl font-black text-white">{{ $globalPerformance }}%</span>
                <div class="w-full bg-slate-800 h-1.5 rounded-full mt-6">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-1.5 rounded-full" style="width: {{ $globalPerformance }}%"></div>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem]">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Staff Présent</p>
                <div class="flex items-center justify-between">
                    <span class="text-5xl font-black text-white">{{ $attendanceToday }}</span>
                    <span class="text-xs font-bold text-blue-500">sur {{ $totalUsers }}</span>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem]">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Congés en attente</p>
                <span class="text-5xl font-black {{ $pendingLeaves > 0 ? 'text-amber-500' : 'text-white' }}">{{ $pendingLeaves }}</span>
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-[2.5rem] flex flex-col items-center justify-center text-center">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Date</p>
                <span class="text-blue-400 font-black uppercase text-sm">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        {{-- Section Présences --}}
        <div class="mb-10">
            <h3 class="text-[10px] font-black uppercase text-slate-500 tracking-widest mb-4">État des présences</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($users as $user)
                    @php
                        $att = $user->attendances->first();
                        $color = $att ? ($att->is_completed ? 'bg-blue-500' : 'bg-emerald-500') : 'bg-slate-800';
                    @endphp
                    <div class="bg-slate-900/40 border border-slate-800 p-4 rounded-3xl flex items-center gap-4">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1e293b&color=3b82f6" class="w-10 h-10 rounded-full">
                            <span class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-slate-900 {{ $color }}"></span>
                        </div>
                        <p class="text-xs font-bold text-white truncate">{{ $user->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Missions --}}
            <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-[2.5rem] p-8">
                <h3 class="text-xs font-black uppercase text-slate-400 mb-6">Missions récentes</h3>
                <div class="space-y-4">
                    @forelse($recentMissions as $mission)
                        <div class="flex items-center justify-between p-4 bg-slate-800/20 rounded-2xl border border-slate-800/50">
                            <span class="text-sm font-bold text-white">{{ $mission->title }}</span>
                            <span class="text-[10px] text-blue-500 font-black">{{ $mission->progress }}%</span>
                        </div>
                    @empty
                        <p class="text-slate-600 text-xs italic">Aucune mission.</p>
                    @endforelse
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] p-8">
                <h3 class="text-xs font-black uppercase mb-6 text-blue-500">Assigner une tâche</h3>
                <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <select name="user_id" class="w-full bg-slate-800 border-none rounded-2xl p-4 text-xs text-white" required>
                        <option value="">Sélectionner...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="title" placeholder="Mission..." class="w-full bg-slate-800 border-none rounded-2xl p-4 text-xs text-white" required>
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black uppercase text-[10px]">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>