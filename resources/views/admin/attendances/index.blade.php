<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 md:p-6 bg-[#0f172a] rounded-[1.5rem] md:rounded-[2.5rem] shadow-2xl border border-slate-800 mt-4 md:mt-8 text-slate-200">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h2 class="text-xl md:text-2xl font-black tracking-tight text-white italic uppercase">SUPERVISION <span class="text-blue-500">PRÉSENCES</span></h2>
                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 tracking-[0.3em] uppercase">Statut en temps réel - {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            </div>
            <div class="bg-slate-900/50 p-3 rounded-2xl border border-blue-500/20 w-full md:w-auto text-center md:text-left">
                <i class="fa-solid fa-users-viewfinder text-blue-400 mr-2"></i>
                <span class="font-mono text-blue-400 font-bold text-xs md:text-base">MODE ADMINISTRATEUR</span>
            </div>
        </div>

        <div class="overflow-x-auto pb-4">
            <table class="w-full text-left border-separate border-spacing-y-3 min-w-[800px]">
                <thead>
                    <tr class="text-[10px] font-black uppercase text-slate-500 tracking-widest">
                        <th class="px-6 py-4">Collaborateur / Planning</th>
                        <th class="px-4 py-4">Arrivée (8h30)</th>
                        <th class="px-4 py-4">Pause (12h)</th>
                        <th class="px-4 py-4">Reprise (14h)</th>
                        <th class="px-4 py-4">Descente (17h)</th>
                        <th class="px-4 py-4">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @php $att = $user->attendances->first(); @endphp
                        <tr class="bg-slate-900/40 border border-slate-800 hover:bg-slate-800/60 transition-all group rounded-2xl">
                            <td class="px-6 py-4 rounded-l-2xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 shrink-0 rounded-full bg-blue-500/10 border border-blue-500/30 flex items-center justify-center font-bold text-blue-400">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div class="truncate max-w-[180px]">
                                        <div class="text-sm font-bold text-white truncate">{{ $user->name }}</div>
                                        {{-- NOUVEAU : AFFICHAGE DU PLANNING SOUS LE NOM --}}
                                        <div class="flex gap-1 mt-1">
                                            @php 
                                                $joursComplets = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                                                $userDays = $user->availability ? $user->availability->days : [];
                                            @endphp
                                            @foreach(['L', 'M', 'M', 'J', 'V'] as $idx => $initiale)
                                                <span class="text-[7px] w-3 h-3 flex items-center justify-center rounded-sm font-black {{ in_array($joursComplets[$idx], $userDays) ? 'bg-blue-500 text-white' : 'bg-slate-800 text-slate-600' }}">
                                                    {{ $initiale }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            @foreach(['check_in_8h30', 'check_out_12h00', 'check_in_14h00', 'check_out_17h00'] as $step)
                                <td class="px-4 py-4">
                                    @if($att && $att->$step)
                                        <span class="text-xs font-mono text-emerald-400 bg-emerald-500/5 px-2 py-1 rounded border border-emerald-500/20">
                                            {{ \Carbon\Carbon::parse($att->$step)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-700 italic">--:--</span>
                                    @endif
                                </td>
                            @endforeach

                            <td class="px-4 py-4 rounded-r-2xl">
                                @if(!$att)
                                    <span class="flex items-center gap-2 text-[10px] font-black text-red-500 uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span> Absent
                                    </span>
                                @elseif($att->is_completed)
                                    <span class="text-[10px] font-black text-emerald-500 uppercase">✅ Journée Finie</span>
                                @else
                                    <span class="text-[10px] font-black text-blue-400 uppercase">⚡ En poste</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>