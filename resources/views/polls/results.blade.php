<x-app-layout>
    <div class="py-12 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-12">
                <a href="{{ route('polls.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-indigo-400 transition-colors">
                    <i class="fa-solid fa-arrow-left-long"></i> Retour
                </a>
                <span class="px-4 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-black uppercase text-indigo-400 tracking-widest">
                    {{ $totalVotes }} {{ Str::plural('Vote', $totalVotes) }} au total
                </span>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black italic tracking-tighter text-white uppercase">
                    Résultats <span class="text-indigo-500 inline-block rotate-3">Live</span>
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-3 px-4">
                    {{ $poll->title }}
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-[2rem] md:rounded-[3rem] p-6 md:p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-600/5 blur-[100px] rounded-full"></div>
                
                <div class="space-y-8 relative">
                    @foreach($stats as $stat)
                        <div class="group">
                            <div class="flex justify-between items-end mb-3 px-2">
                                <div class="flex flex-col max-w-[70%]">
                                    <span class="text-xs font-black uppercase tracking-widest text-gray-400 group-hover:text-white transition-colors truncate">
                                        {{ $stat['option'] }}
                                    </span>
                                    <span class="text-[10px] font-bold text-gray-600">
                                        {{ $stat['count'] }} voix
                                    </span>
                                </div>
                                <span class="text-xl font-black italic tracking-tighter text-indigo-500 shrink-0">
                                    {{ $stat['percentage'] }}%
                                </span>
                            </div>
                            
                            <div class="h-4 w-full bg-gray-950 border border-gray-800 rounded-full p-1 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-600 to-violet-500 rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(79,70,229,0.4)]"
                                     style="width: {{ $stat['percentage'] }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="bg-gray-900/50 border border-gray-800 p-5 md:p-6 rounded-3xl flex items-center gap-5">
                    <div class="shrink-0 w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-600">Lancé le</p>
                        <p class="text-sm font-bold text-gray-300">{{ $poll->created_at->format('d F Y') }}</p>
                    </div>
                </div>

                <div class="bg-gray-900/50 border border-gray-800 p-5 md:p-6 rounded-3xl flex items-center gap-5">
                    <div class="shrink-0 w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-600">Confidentialité</p>
                        <p class="text-sm font-bold text-gray-300">Identités protégées</p>
                    </div>
                </div>
            </div>

            @if(auth()->user()->can('admin-only'))
                <div class="mt-10 text-center">
                    <button class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-500/50 hover:text-rose-500 transition-colors">
                        <i class="fa-solid fa-circle-stop mr-2"></i> Clôturer les votes
                    </button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>