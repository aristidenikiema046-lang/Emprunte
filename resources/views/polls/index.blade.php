<x-app-layout>
    <div class="py-6 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-square-poll-vertical text-indigo-500 text-xs"></i>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">Feedback Communautaire</span>
                    </div>
                    <h2 class="text-4xl font-black italic tracking-tighter text-white uppercase">
                        Les <span class="text-indigo-500">Sondages</span>
                    </h2>
                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-2">
                        Exprimez-vous pour faire évoluer <span class="text-white">Emprunte</span>
                    </p>
                </div>
                
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('polls.create') }}" class="group flex items-center gap-3 bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
                        Nouveau sondage
                    </a>
                @endif
            </div>

            {{-- Table Card --}}
            <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-950/50">
                            <tr>
                                <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Sujet du Sondage</th>
                                <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Auteur</th>
                                <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">Date de lancement</th>
                                <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Analyse</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/50">
                            @forelse($polls as $poll)
                            <tr class="hover:bg-indigo-500/[0.02] transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 rounded-xl bg-gray-950 border border-gray-800 flex items-center justify-center group-hover:border-indigo-500/50 transition-all">
                                            <i class="fa-solid fa-comment-dots text-indigo-500 opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-white text-base tracking-tight group-hover:text-indigo-400 transition-colors uppercase">
                                                {{ $poll->title }}
                                            </span>
                                            @if(!$poll->hasVoted(auth()->id()))
                                                <a href="{{ route('polls.show', $poll) }}" class="inline-flex items-center gap-2 text-[10px] text-indigo-400 font-black mt-1 uppercase tracking-widest hover:text-white transition-colors">
                                                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-ping"></span>
                                                    Voter maintenant <i class="fa-solid fa-arrow-right-long ml-1"></i>
                                                </a>
                                            @else
                                                <span class="text-[9px] text-emerald-500 font-black mt-1 uppercase tracking-widest flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-check"></i> Participation enregistrée
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-[10px] font-black text-gray-400 bg-gray-950 px-3 py-1.5 rounded-lg border border-gray-800 uppercase">
                                        Admin ManageX
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="font-mono text-xs text-gray-500 group-hover:text-gray-300 transition-colors">
                                        {{ $poll->created_at->format('d.m.Y') }}
                                        <span class="text-[10px] opacity-30 ml-1">@ {{ $poll->created_at->format('H:i') }}</span>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('polls.results', $poll) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-950 border border-gray-800 text-gray-500 hover:border-indigo-500 hover:text-indigo-400 hover:shadow-lg hover:shadow-indigo-500/10 transition-all">
                                        <i class="fa-solid fa-chart-pie"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div class="w-20 h-20 bg-gray-950 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-800">
                                        <i class="fa-solid fa-box-archive text-gray-700 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-sm font-bold tracking-tight">Aucun sondage actif</p>
                                    <p class="text-gray-700 text-[9px] uppercase font-black mt-2 tracking-widest">Le silence est d'or, mais votre avis nous manque.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tips Footer --}}
            <div class="mt-8 flex items-center justify-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-600">
                <span class="w-12 h-[1px] bg-gray-800"></span>
                <span>Anonymat garanti sur tous les votes</span>
                <span class="w-12 h-[1px] bg-gray-800"></span>
            </div>
        </div>
    </div>
</x-app-layout>