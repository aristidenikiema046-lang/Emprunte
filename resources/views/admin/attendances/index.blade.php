<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-[#0f172a] rounded-[2.5rem] shadow-2xl border border-slate-800 mt-8 text-slate-200">
        
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-white italic uppercase">SUPERVISION <span class="text-blue-500">PRÉSENCES</span></h2>
                <p class="text-[10px] font-bold text-slate-500 tracking-[0.3em] uppercase">Statut en temps réel - {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            </div>
            <div class="bg-slate-900/50 p-3 rounded-2xl border border-blue-500/20">
                <i class="fa-solid fa-users-viewfinder text-blue-400 mr-2"></i>
                <span class="font-mono text-blue-400 font-bold">MODE ADMINISTRATEUR</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-[10px] font-black uppercase text-slate-500 tracking-widest">
                        <th class="px-6 py-4">Collaborateur</th>
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
                                    <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-blue-500/30 flex items-center justify-center font-bold text-blue-400">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-white">{{ $user->name }}</div>
                                        <div class="text-[10px] text-slate-500 lowercase">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Colonnes de pointage --}}
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