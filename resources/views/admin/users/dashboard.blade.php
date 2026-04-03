<x-app-layout>
    <div class="py-6 space-y-10">
        
        {{-- 1. HEADER : IDENTITÉ RENFORCÉE --}}
        <div class="flex flex-col md:flex-row justify-between items-start gap-4 px-2">
            <div>
                <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-none">
                    @if(Auth::user()->is_admin) Console <span class="text-blue-600">Admin</span> @else Mon <span class="text-blue-600">Espace</span> @endif
                </h2>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.2em] mt-2 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-ping"></span>
                    Système ManageX opérationnel — {{ now()->translatedFormat('H:i') }}
                </p>
            </div>
            
            <div class="w-full md:w-80 space-y-2">
                @foreach($notifications as $note)
                <div class="p-3 bg-{{ $note['type'] }}-500/10 border border-{{ $note['type'] }}-500/20 rounded-xl flex items-center gap-3">
                    <div class="w-1.5 h-1.5 rounded-full bg-{{ $note['type'] }}-500"></div>
                    <p class="text-[9px] font-black text-{{ $note['type'] }}-200 uppercase tracking-tighter">{{ $note['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- 2. GRID DE NAVIGATION : LES 6 TUILES D'ACCÈS DIRECT --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $navItems = [
                    ['route' => 'attendances.index', 'icon' => 'fa-fingerprint', 'color' => 'blue', 'label' => 'Présences', 'sub' => 'Pointage'],
                    ['route' => 'tasks.index', 'icon' => 'fa-list-check', 'color' => 'emerald', 'label' => 'Missions', 'sub' => 'Tâches'],
                    ['route' => 'leaves.index', 'icon' => 'fa-calendar-day', 'color' => 'orange', 'label' => 'Congés', 'sub' => 'Demandes'],
                    ['route' => 'messages.index', 'icon' => 'fa-comments', 'color' => 'purple', 'label' => 'Messages', 'sub' => 'Interne'],
                    ['route' => 'documents.received', 'icon' => 'fa-file-pdf', 'color' => 'red', 'label' => 'Docs', 'sub' => 'Fichiers'],
                    ['route' => 'profile.show', 'icon' => 'fa-user-gear', 'color' => 'gray', 'label' => 'Profil', 'sub' => 'Compte'],
                ];
            @endphp

            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}" class="group bg-gray-900/50 p-5 rounded-[2rem] border border-white/5 hover:border-{{ $item['color'] }}-500/50 hover:bg-gray-900 transition-all duration-300 relative overflow-hidden shadow-xl">
                <div class="relative z-10">
                    <i class="fa-solid {{ $item['icon'] }} text-2xl text-{{ $item['color'] }}-500 mb-3 group-hover:scale-110 transition-transform"></i>
                    <span class="block text-[11px] font-black text-white uppercase tracking-tight">{{ $item['label'] }}</span>
                    <span class="block text-[8px] font-bold text-gray-500 uppercase tracking-widest">{{ $item['sub'] }}</span>
                </div>
                {{-- Effet de lueur au hover --}}
                <div class="absolute -right-4 -bottom-4 w-12 h-12 bg-{{ $item['color'] }}-500/5 rounded-full blur-2xl group-hover:bg-{{ $item['color'] }}-500/20 transition-all"></div>
            </a>
            @endforeach
        </div>

        {{-- 3. SECTION ANALYSE : MISSIONS & PERFORMANCE --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- BLOC MISSIONS (User ou Admin Live) --}}
            <div class="lg:col-span-8 bg-gray-900 p-8 rounded-[3rem] border border-white/5 shadow-2xl relative overflow-hidden">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-white font-black uppercase text-xs tracking-[0.2em] flex items-center gap-3">
                        <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span> 
                        Focus Opérationnel
                    </h3>
                    <span class="text-[9px] font-black text-gray-600 uppercase italic">Mise à jour en temps réel</span>
                </div>

                <div class="space-y-4">
                    @forelse($myTasks as $task)
                    <div class="flex items-center justify-between p-5 bg-slate-950/40 rounded-[2rem] border border-white/5 group hover:border-blue-500/20 transition-all">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center text-blue-500 border border-white/5 group-hover:text-white group-hover:bg-blue-600 transition-all">
                                <i class="fa-solid fa-bolt-lightning"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-white uppercase tracking-tight">{{ $task->title }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[8px] font-black text-blue-500 uppercase px-2 py-0.5 bg-blue-500/10 rounded">Priorité {{ $task->priority }}</span>
                                    <span class="text-[9px] font-bold text-gray-600 uppercase italic">Ref: #TX-{{ $task->id }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('tasks.index') }}" class="h-10 w-10 flex items-center justify-center bg-gray-900 text-gray-600 rounded-xl hover:text-white hover:bg-blue-600 transition-all">
                            <i class="fa-solid fa-arrow-right-long text-xs"></i>
                        </a>
                    </div>
                    @empty
                    <div class="py-12 text-center">
                        <p class="text-gray-700 text-[10px] font-black uppercase tracking-[0.3em] italic">Aucun processus en cours</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- BLOC PERFORMANCE & PROFIL --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- Indice de Performance (Luminous Style) --}}
                <div class="bg-blue-600 p-8 rounded-[3rem] text-white shadow-[0_20px_50px_rgba(37,99,235,0.3)] relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-widest mb-6 opacity-60">Indice Global / 9</p>
                        <div class="flex items-baseline gap-1 mb-6">
                            <h3 class="text-7xl font-black italic tracking-tighter">
                                {{ $lastEval ? number_format($lastEval->total_score, 1) : '0.0' }}
                            </h3>
                            <span class="text-2xl font-black opacity-30">.9</span>
                        </div>
                        
                        {{-- Barre de progression lumineuse --}}
                        <div class="w-full bg-black/20 h-3 rounded-full overflow-hidden shadow-inner">
                            @php $perfPercent = (($lastEval->total_score ?? 0) / 9) * 100; @endphp
                            <div class="bg-white h-full shadow-[0_0_20px_#fff] transition-all duration-1000" style="width: {{ $perfPercent }}%"></div>
                        </div>
                        <p class="mt-4 text-[9px] font-bold uppercase opacity-80 italic">Performance calculée sur vos derniers objectifs</p>
                    </div>
                    {{-- Décoration fond --}}
                    <i class="fa-solid fa-chart-line absolute -right-4 -bottom-4 text-8xl text-white/10 -rotate-12 group-hover:rotate-0 transition-transform duration-700"></i>
                </div>

                {{-- Widget Profil Compact --}}
                <div class="bg-gray-900 p-6 rounded-[2.5rem] border border-white/5 flex items-center gap-4">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff' }}" class="w-14 h-14 rounded-2xl object-cover border border-white/10">
                    <div>
                        <h4 class="text-sm font-black text-white uppercase leading-none">{{ Auth::user()->name }}</h4>
                        <p class="text-[9px] font-bold text-blue-500 uppercase tracking-widest mt-1">{{ Auth::user()->post }}</p>
                        <div class="flex gap-2 mt-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_8px_#10b981]"></span>
                            <span class="text-[8px] text-gray-600 font-black uppercase">Statut : Actif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>