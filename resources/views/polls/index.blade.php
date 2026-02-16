<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold tracking-tight">Sondages</h2>
                
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('polls.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white px-6 py-2.5 rounded-full text-sm font-bold transition shadow-lg shadow-indigo-500/20">
                        Nouveau sondage
                    </a>
                @endif
            </div>

            <div class="bg-[#1e293b] rounded-[2rem] border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-slate-900/40 text-slate-500 text-[11px] uppercase font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Titre</th>
                            <th class="px-8 py-5">Créé par</th>
                            <th class="px-8 py-5">Créé le</th>
                            <th class="px-8 py-5">Résultats</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm">
                        @forelse($polls as $poll)
                        <tr class="hover:bg-slate-800/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-200 group-hover:text-white transition-colors uppercase tracking-tight">
                                        {{ $poll->title }}
                                    </span>
                                    @if(!$poll->hasVoted(auth()->id()))
                                        <a href="{{ route('polls.show', $poll) }}" class="text-[10px] text-indigo-400 font-bold mt-1 hover:underline">
                                            Voter maintenant →
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-400 font-medium">
                                Admin ManageX
                            </td>
                            <td class="px-8 py-5 text-slate-400 font-mono text-xs">
                                {{ $poll->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-8 py-5">
                                <a href="{{ route('polls.results', $poll) }}" class="text-indigo-400 hover:text-indigo-300 font-bold transition-all flex items-center gap-2">
                                    Voir
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-500 italic">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Aucun sondage disponible.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>