<x-app-layout>
    <div class="py-6 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-black italic uppercase tracking-widest text-white">
                        Bulletins de <span class="text-blue-500">paie</span>
                    </h2>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter mt-1">
                        {{ auth()->user()->role === 'admin' ? 'Gestion des rémunérations équipe' : 'Mon historique de paiements' }}
                    </p>
                </div>
                
                @if(auth()->user()->role === 'admin')
                <div class="flex gap-2">
                    <button class="bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg transition shadow-pink-600/20">Exporter PDF</button>
                    <button class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg transition shadow-emerald-600/20">Excel</button>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 {{ auth()->user()->role === 'admin' ? 'lg:grid-cols-3' : '' }} gap-8">
                
                @if(auth()->user()->role === 'admin')
                <div class="bg-slate-900 p-8 rounded-[2.5rem] border border-slate-800 shadow-2xl h-fit">
                    <h3 class="text-lg font-black uppercase mb-6 italic text-blue-400">Nouveau bulletin</h3>
                    <form action="{{ route('payroll.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <select name="user_id" class="w-full bg-slate-800 border-none rounded-2xl text-white focus:ring-2 focus:ring-blue-500 p-4 text-sm" required>
                            <option value="">Choisir l'employé</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <input type="month" name="month" class="w-full bg-slate-800 border-none rounded-2xl text-white focus:ring-2 focus:ring-blue-500 p-4 text-sm" required>
                        <input type="number" name="amount" placeholder="Montant (FCFA)" class="w-full bg-slate-800 border-none rounded-2xl text-white focus:ring-2 focus:ring-blue-500 p-4 text-sm" required>
                        <select name="status" class="w-full bg-slate-800 border-none rounded-2xl text-white focus:ring-2 focus:ring-blue-500 p-4 text-sm">
                            <option value="Payé">Payé</option>
                            <option value="En attente">En attente</option>
                        </select>
                        <input type="file" name="pdf" accept=".pdf" class="text-xs text-slate-500">
                        <button type="submit" class="w-full bg-blue-600 py-4 rounded-2xl font-black uppercase text-xs hover:bg-blue-500 shadow-lg shadow-blue-600/20">Enregistrer</button>
                    </form>
                </div>
                @endif

                <div class="{{ auth()->user()->role === 'admin' ? 'lg:col-span-2' : 'lg:col-span-3' }} bg-slate-900 rounded-[2.5rem] border border-slate-800 overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                            <tr>
                                @if(auth()->user()->role === 'admin') <th class="px-8 py-5">Collaborateur</th> @endif
                                <th class="px-8 py-5">Période</th>
                                <th class="px-8 py-5">Montant Net</th>
                                <th class="px-8 py-5">Statut</th>
                                <th class="px-8 py-5 text-center">Fichier</th>
                                @if(auth()->user()->role === 'admin') <th class="px-8 py-5 text-right">Action</th> @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 text-sm">
                            @forelse($payrolls as $payroll)
                            <tr class="hover:bg-slate-800/30 transition group">
                                @if(auth()->user()->role === 'admin')
                                <td class="px-8 py-5 font-bold text-slate-200">{{ $payroll->user->name }}</td>
                                @endif
                                <td class="px-8 py-5 font-bold uppercase text-xs">
                                    {{ \Carbon\Carbon::parse($payroll->month)->translatedFormat('F Y') }}
                                </td>
                                <td class="px-8 py-5 font-mono font-bold text-emerald-500">
                                    {{ number_format($payroll->amount, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase {{ $payroll->status == 'Payé' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-orange-500/10 text-orange-400' }}">
                                        {{ $payroll->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($payroll->pdf_path)
                                        <a href="{{ asset('storage/' . $payroll->pdf_path) }}" target="_blank" class="text-blue-400 hover:text-blue-300 text-[10px] font-black uppercase">Voir PDF</a>
                                    @else
                                        <span class="text-slate-600 text-xs">-</span>
                                    @endif
                                </td>
                                @if(auth()->user()->role === 'admin')
                                <td class="px-8 py-5 text-right">
                                    <form action="{{ route('payroll.destroy', $payroll) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-slate-600 hover:text-red-500 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center text-slate-600 text-xs italic font-bold uppercase">Aucune donnée disponible</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>