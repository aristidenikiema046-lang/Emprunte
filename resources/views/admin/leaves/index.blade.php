<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 p-8 rounded-[2.5rem] border border-slate-700 shadow-2xl">
                <h2 class="text-2xl font-black mb-8 flex items-center gap-3">
                    <i class="fa-solid fa-plane-departure text-indigo-500"></i>
                    Gestion des Congés
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-slate-500 border-b border-slate-700 text-[10px] uppercase tracking-widest font-black">
                                <th class="pb-4">Collaborateur</th>
                                <th class="pb-4">Type & Dates</th>
                                <th class="pb-4">Justificatif</th>
                                <th class="pb-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @foreach($leaves as $leave)
                            <tr class="group hover:bg-slate-700/30 transition-colors">
                                <td class="py-5">
                                    <div class="font-bold text-white">{{ $leave->user->name }}</div>
                                    <div class="text-[10px] text-slate-500 uppercase">{{ $leave->user->role }}</div>
                                </td>
                                <td class="py-5">
                                    <div class="text-sm font-medium text-indigo-300">{{ $leave->type }}</div>
                                    <div class="text-xs text-slate-400">Du {{ $leave->start_date }} au {{ $leave->end_date }}</div>
                                </td>
                                <td class="py-5">
                                    @if($leave->attachment)
                                        <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank" class="flex items-center gap-2 text-xs bg-indigo-500/10 text-indigo-400 px-3 py-2 rounded-xl border border-indigo-500/20 w-fit hover:bg-indigo-500 hover:text-white transition">
                                            <i class="fa-solid fa-eye"></i> Voir la PJ
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-600 italic">Aucun document</span>
                                    @endif
                                </td>
                                <td class="py-5 text-right">
                                    @if($leave->status === 'en_attente')
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="approuvé">
                                                <button class="bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-500 hover:text-white transition">Approuver</button>
                                            </form>
                                            <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="refusé">
                                                <button class="bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-red-500 hover:text-white transition">Refuser</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black uppercase px-3 py-1 rounded-lg {{ $leave->status == 'approuvé' ? 'text-emerald-500 bg-emerald-500/5' : 'text-red-500 bg-red-500/5' }}">
                                            {{ $leave->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>