<x-app-layout>
    <div class="py-6 bg-slate-900 min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold italic">Validation des demandes de congés</h2>
                <div class="flex gap-2">
                    <button class="bg-pink-600 px-4 py-2 rounded-lg text-xs font-bold shadow-lg">Exporter PDF</button>
                    <button class="bg-emerald-600 px-4 py-2 rounded-lg text-xs font-bold shadow-lg">Exporter Excel</button>
                </div>
            </div>

            <div class="bg-slate-800 rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-slate-900/50 text-slate-400 text-xs uppercase font-black">
                        <tr>
                            <th class="px-6 py-4">Collaborateur</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Motif</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700 text-sm">
                        @foreach($leaves as $leave)
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="px-6 py-4 font-bold text-indigo-400">{{ $leave->user->name }}</td>
                            <td class="px-6 py-4">{{ $leave->type }}</td>
                            <td class="px-6 py-4">Du {{ $leave->start_date }} au {{ $leave->end_date }}</td>
                            <td class="px-6 py-4 italic text-slate-400">"{{ $leave->reason }}"</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-black
                                    {{ $leave->status == 'approuvé' ? 'bg-green-500 text-white' : 
                                       ($leave->status == 'refusé' ? 'bg-red-500 text-white' : 'bg-yellow-500 text-black') }}">
                                    {{ strtoupper($leave->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-4">
                                @if($leave->status == 'en_attente')
                                    <form action="{{ route('leaves.update', $leave) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approuvé">
                                        <button class="text-green-400 hover:text-green-200 font-bold uppercase text-xs tracking-widest">Accepter</button>
                                    </form>
                                    <form action="{{ route('leaves.update', $leave) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="refusé">
                                        <button class="text-red-400 hover:text-red-200 font-bold uppercase text-xs tracking-widest">Refuser</button>
                                    </form>
                                @else
                                    <span class="text-slate-600 italic">Traité</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>