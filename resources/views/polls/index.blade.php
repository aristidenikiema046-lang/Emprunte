<x-app-layout>
    <div class="py-12 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black italic tracking-tighter text-white uppercase">
                        Sondages <span class="text-indigo-500">Disponibles</span>
                    </h2>
                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-2">
                        Votre avis aide à faire progresser l'équipe
                    </p>
                </div>

                @can('admin-only')
                    <a href="{{ route('polls.create') }}" class="w-full sm:w-auto justify-center bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20 flex items-center gap-3">
                        <i class="fa-solid fa-plus"></i> Nouveau Sondage
                    </a>
                @endcan
            </div>

            <div class="grid gap-6">
                @forelse($polls as $poll)
                    <div class="bg-gray-900 border border-gray-800 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-6 hover:border-gray-700 transition-all group">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="shrink-0 w-2 h-2 rounded-full {{ $poll->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                    <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $poll->title }}</h3>
                                </div>
                                <p class="text-gray-500 text-sm line-clamp-2 md:line-clamp-1">{{ $poll->description ?? 'Aucune description fournie.' }}</p>
                            </div>

                            <div class="flex items-center gap-4">
                                @if($poll->hasVoted(auth()->id()))
                                    <a href="{{ route('polls.results', $poll) }}" class="w-full md:w-auto text-center px-6 py-3 bg-gray-950 border border-gray-800 text-gray-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-white transition-all">
                                        Voir Résultats
                                    </a>
                                @else
                                    <a href="{{ route('polls.show', $poll) }}" class="w-full md:w-auto text-center px-6 py-3 bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all">
                                        Voter maintenant
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-gray-900/50 border border-dashed border-gray-800 rounded-[2rem] md:rounded-[3rem] px-4">
                        <i class="fa-solid fa-inbox text-4xl text-gray-800 mb-4"></i>
                        <p class="text-gray-600 font-bold uppercase text-[10px] tracking-widest">Aucun sondage pour le moment</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>