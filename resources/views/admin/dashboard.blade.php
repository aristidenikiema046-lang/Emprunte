<x-app-layout>
    <div class="py-6 px-4 md:px-0 space-y-10">
        
        {{-- 1. HEADER : IDENTITÉ RENFORCÉE --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 px-2">
            <div>
                <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter leading-none">
                    Console <span class="text-blue-600 italic">Admin</span>
                </h2>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.3em] mt-3 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-ping"></span>
                    Surveillance active — {{ now()->translatedFormat('H:i') }}
                </p>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-white font-black text-xl uppercase tracking-tighter">{{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-blue-500 text-[9px] font-black uppercase tracking-[0.2em] italic">ManageX Core System</p>
            </div>
        </div>

        {{-- 2. GRID DE NAVIGATION : LES 6 TUILES D'ACCÈS DIRECT --}}
        {{-- S'adapte de 2 colonnes (mobile) à 6 colonnes (desktop) --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $navItems = [
                    ['route' => 'attendances.index', 'icon' => 'fa-fingerprint', 'color' => 'blue', 'label' => 'Présences'],
                    ['route' => 'tasks.index', 'icon' => 'fa-list-check', 'color' => 'emerald', 'label' => 'Missions'],
                    ['route' => 'leaves.index', 'icon' => 'fa-calendar-day', 'color' => 'orange', 'label' => 'Congés'],
                    ['route' => 'messages.index', 'icon' => 'fa-comments', 'color' => 'purple', 'label' => 'Messages'],
                    ['route' => 'documents.received', 'icon' => 'fa-file-pdf', 'color' => 'red', 'label' => 'Documents'],
                    ['route' => 'users.index', 'icon' => 'fa-user-gear', 'color' => 'gray', 'label' => 'Paramètres'],
                ];
            @endphp

            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}" class="group bg-gray-900/50 p-6 rounded-[2rem] border border-white/5 hover:border-{{ $item['color'] }}-500/50 hover:bg-gray-900 transition-all duration-300 relative overflow-hidden shadow-xl">
                <div class="relative z-10 text-center md:text-left">
                    <i class="fa-solid {{ $item['icon'] }} text-2xl text-{{ $item['color'] }}-500 mb-3 group-hover:scale-110 transition-transform"></i>
                    <span class="block text-[11px] font-black text-white uppercase tracking-tighter group-hover:text-{{ $item['color'] }}-400 transition-colors">{{ $item['label'] }}</span>
                </div>
                <div class="absolute -right-4 -bottom-4 w-12 h-12 bg-{{ $item['color'] }}-500/5 rounded-full blur-2xl group-hover:bg-{{ $item['color'] }}-500/20 transition-all"></div>
            </a>
            @endforeach
        </div>

        {{-- 3. STATS RAPIDES & PERFORMANCE GLOBALE --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 p-8 rounded-[2.5rem] border border-white/5 relative overflow-hidden group">
                <p class="text-[10px] font-black text-gray-500 uppercase mb-4 tracking-widest">Effectif Total</p>
                <h3 class="text-5xl font-black text-white">{{ $totalUsers }}</h3>
                <i class="fa-solid fa-users-viewfinder absolute right-8 bottom-8 text-4xl text-white/5 group-hover:text-blue-500/10 transition-colors"></i>
            </div>

            <div class="bg-gray-900 p-8 rounded-[2.5rem] border border-white/5">
                <p class="text-[10px] font-black text-gray-500 uppercase mb-4 tracking-widest">Présences Live</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-5xl font-black text-emerald-500">{{ $attendanceToday }}</h3>
                    <span class="text-gray-600 font-black text-sm uppercase">/ {{ $totalUsers }}</span>
                </div>
            </div>

            {{-- INDICE DE PERFORMANCE LUMINEUX --}}
            <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-[0_20px_50px_rgba(37,99,235,0.3)] relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 opacity-70 italic">Performance Global</p>
                <div class="flex items-baseline gap-1 mb-4">
                    <h3 class="text-5xl font-black italic tracking-tighter">{{ number_format($globalPerformance, 1) }}</h3>
                    <span class="text-xl font-black opacity-40">/ 9</span>
                </div>
                {{-- Barre de progression lumineuse --}}
                <div class="w-full bg-black/20 h-2 rounded-full overflow-hidden shadow-inner">
                    <div class="bg-white h-full shadow-[0_0_15px_rgba(255,255,255,0.8)] transition-all duration-1000" style="width: {{ ($globalPerformance/9)*100 }}%"></div>
                </div>
            </div>
        </div>

        {{-- 4. TABLEAU DE SURVEILLANCE & MISSIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- SURVEILLANCE LIVE --}}
            <div class="lg:col-span-8 bg-gray-900 rounded-[3rem] border border-white/5 overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-white/5 flex justify-between items-center bg-slate-950/30">
                    <h3 class="text-white font-black uppercase text-xs tracking-[0.2em] italic flex items-center gap-3">
                        <span class="w-1 h-4 bg-blue-600 rounded-full"></span> Surveillance des effectifs
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950/50">
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Collaborateur</th>
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Statut</th>
                                <th class="p-6 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Détails</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $emp)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=2563eb&color=fff" class="w-10 h-10 rounded-xl border border-white/10 group-hover:scale-110 transition-transform">
                                        <div>
                                            <p class="text-sm font-black text-white uppercase tracking-tight">{{ $emp->name }}</p>
                                            <p class="text-[9px] font-bold text-gray-600 uppercase">{{ $emp->department ?? 'Standard' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    @if($emp->attendances->isNotEmpty())
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[9px] font-black rounded-lg border border-emerald-500/20 uppercase tracking-tighter">Présent</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/10 text-red-500 text-[9px] font-black rounded-lg border border-red-500/20 uppercase tracking-tighter">Absent</span>
                                    @endif
                                </td>
                                <td class="p-6 text-right">
                                    <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800 text-gray-500 hover:text-white hover:bg-blue-600 transition-all">
                                        <i class="fa-solid fa-angle-right text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MISSIONS RÉCENTES --}}
            <div class="lg:col-span-4 bg-slate-950 p-8 rounded-[3rem] border border-white/5 shadow-2xl relative overflow-hidden">
                <h3 class="text-white font-black uppercase text-xs tracking-[0.2em] mb-8 italic">Missions Récentes</h3>
                <div class="space-y-6">
                    @forelse($recentMissions as $mission)
                    <div class="relative pl-6 border-l-2 border-blue-600/20 group hover:border-blue-600 transition-colors">
                        <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-blue-600 shadow-[0_0_10px_#2563eb]"></div>
                        <p class="text-[9px] font-black text-blue-500 uppercase mb-1">{{ $mission->user->name }}</p>
                        <p class="text-xs font-bold text-gray-300 uppercase tracking-tight leading-tight">{{ $mission->title }}</p>
                        <p class="text-[8px] text-gray-600 font-black mt-2 uppercase italic tracking-widest">{{ $mission->updated_at->diffForHumans() }}</p>
                    </div>
                    @empty
                    <p class="text-gray-700 text-[10px] uppercase font-black text-center italic py-10">Zéro activité détectée</p>
                    @endforelse
                </div>
                
                <a href="{{ route('tasks.index') }}" class="w-full mt-10 flex items-center justify-center gap-3 py-4 bg-white/[0.03] border border-white/5 hover:bg-blue-600 text-gray-400 hover:text-white rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all">
                    Toutes les tâches <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>