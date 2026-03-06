<x-app-layout>
    <div class="py-6 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- En-tête Dynamique --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-file-invoice-dollar text-emerald-500 text-xs"></i>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">Finance & RH</span>
                    </div>
                    <h2 class="text-4xl font-black italic tracking-tighter text-white uppercase">
                        Bulletins de <span class="text-emerald-500">paie</span>
                    </h2>
                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-2">
                        {{ auth()->user()->role === 'admin' ? 'Administration des flux financiers' : 'Portail de rémunération personnel' }}
                    </p>
                </div>
                
                @if(auth()->user()->role === 'admin')
                <div class="flex gap-3">
                    <button class="flex items-center gap-2 bg-gray-900 hover:bg-gray-800 border border-gray-800 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                        <i class="fa-solid fa-file-pdf text-red-500"></i> Exporter
                    </button>
                    <button class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20 transition-all">
                        <i class="fa-solid fa-file-excel"></i> Audit Excel
                    </button>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 {{ auth()->user()->role === 'admin' ? 'lg:grid-cols-3' : '' }} gap-8">
                
                {{-- Formulaire d'émission (Admin) --}}
                @if(auth()->user()->role === 'admin')
                <div class="lg:col-span-1">
                    <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] shadow-2xl sticky top-6">
                        <h3 class="text-sm font-black uppercase mb-8 italic text-white flex items-center gap-3">
                            <span class="w-8 h-[1px] bg-emerald-500"></span>
                            Émettre un bulletin
                        </h3>
                        
                        <form action="{{ route('payroll.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Collaborateur</label>
                                <select name="user_id" class="w-full bg-gray-950 border-gray-800 rounded-xl text-gray-300 focus:border-emerald-500 focus:ring-0 py-3.5 text-sm transition-all" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Période</label>
                                    <input type="month" name="month" class="w-full bg-gray-950 border-gray-800 rounded-xl text-gray-300 focus:border-emerald-500 focus:ring-0 py-3 text-sm transition-all" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Statut</label>
                                    <select name="status" class="w-full bg-gray-950 border-gray-800 rounded-xl text-gray-300 focus:border-emerald-500 focus:ring-0 py-3 text-sm transition-all">
                                        <option value="Payé">Payé</option>
                                        <option value="En attente">En attente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Montant Net (FCFA)</label>
                                <input type="number" name="amount" placeholder="000 000" class="w-full bg-gray-950 border-gray-800 rounded-xl text-white font-mono focus:border-emerald-500 focus:ring-0 py-3.5 text-sm transition-all" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Document PDF</label>
                                <div class="relative group">
                                    <input type="file" name="pdf" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="w-full bg-gray-950 border-2 border-dashed border-gray-800 rounded-xl py-4 text-center group-hover:border-emerald-500/50 transition-all">
                                        <i class="fa-solid fa-cloud-arrow-up text-gray-600 mb-2"></i>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase">Joindre le bulletin</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                                Valider l'opération
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                {{-- Liste des Paiements --}}
                <div class="{{ auth()->user()->role === 'admin' ? 'lg:col-span-2' : 'lg:col-span-3' }}">
                    <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] shadow-2xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-950/50">
                                    <tr>
                                        @if(auth()->user()->role === 'admin') 
                                            <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Collaborateur</th> 
                                        @endif
                                        <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Période</th>
                                        <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">Montant Net</th>
                                        <th class="px-8 py-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">État</th>
                                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">Archive</th>
                                        @if(auth()->user()->role === 'admin') 
                                            <th class="px-8 py-6 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Actions</th> 
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800/50">
                                    @forelse($payrolls as $payroll)
                                    <tr class="hover:bg-gray-800/20 transition-all group">
                                        @if(auth()->user()->role === 'admin')
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center text-[10px] font-black text-emerald-500 border border-gray-700">
                                                    {{ substr($payroll->user->name, 0, 2) }}
                                                </div>
                                                <span class="font-bold text-white text-sm">{{ $payroll->user->name }}</span>
                                            </div>
                                        </td>
                                        @endif
                                        <td class="px-8 py-6">
                                            <span class="text-xs font-black uppercase tracking-tighter text-gray-400 group-hover:text-white transition-colors">
                                                {{ \Carbon\Carbon::parse($payroll->month)->translatedFormat('F Y') }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span class="font-mono font-bold text-emerald-500 text-base">
                                                {{ number_format($payroll->amount, 0, ',', ' ') }} <span class="text-[10px] opacity-50">FCFA</span>
                                            </span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $payroll->status == 'Payé' ? 'bg-emerald-500 animate-pulse' : 'bg-orange-500' }}"></span>
                                                <span class="text-[10px] font-black uppercase {{ $payroll->status == 'Payé' ? 'text-emerald-500' : 'text-orange-500' }}">
                                                    {{ $payroll->status }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-center">
                                            @if($payroll->pdf_path)
                                                <a href="{{ asset('storage/' . $payroll->pdf_path) }}" target="_blank" 
                                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-500/5 border border-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white transition-all text-[9px] font-black uppercase">
                                                    <i class="fa-solid fa-download"></i> PDF
                                                </a>
                                            @else
                                                <span class="text-gray-700 text-[10px] font-black uppercase">N/A</span>
                                            @endif
                                        </td>
                                        @if(auth()->user()->role === 'admin')
                                        <td class="px-8 py-6 text-right">
                                            <form action="{{ route('payroll.destroy', $payroll) }}" method="POST" onsubmit="return confirm('Supprimer ce bulletin ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-700 hover:text-red-500 transition-colors">
                                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-8 py-24 text-center">
                                            <div class="opacity-20 mb-4 text-4xl"><i class="fa-solid fa-box-open"></i></div>
                                            <p class="text-gray-600 text-[10px] font-black uppercase tracking-[0.3em]">Aucune archive détectée</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>