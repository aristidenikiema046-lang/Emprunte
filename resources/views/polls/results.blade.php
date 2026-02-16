<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-[#1e293b] p-8 rounded-[2.5rem] border border-slate-700 shadow-2xl">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h2 class="text-2xl font-black italic tracking-tighter uppercase">{{ $poll->title }}</h2>
                        <p class="text-slate-500 font-bold text-xs mt-1">{{ $totalVotes }} participants au total</p>
                    </div>
                    <a href="{{ route('polls.index') }}" class="text-slate-400 hover:text-white text-sm font-bold underline">Retour</a>
                </div>

                <div class="space-y-8">
                    @foreach($stats as $stat)
                    <div>
                        <div class="flex justify-between mb-2 text-sm font-bold uppercase tracking-widest">
                            <span class="text-slate-300">{{ $stat['option'] }}</span>
                            <span class="text-indigo-400">{{ $stat['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-[#0f172a] rounded-full h-4 overflow-hidden border border-slate-800">
                            <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000" style="width: {{ $stat['percentage'] }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-1 ml-1">{{ $stat['count'] }} votes</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>