<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto px-4">
            
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-black italic tracking-tighter uppercase">{{ $title }}</h2>
                <a href="{{ route('documents.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-full text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                    Nouveau document
                </a>
            </div>

            <div class="bg-[#1e293b] rounded-[2rem] border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-slate-900/40 text-slate-500 text-[11px] uppercase font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Document</th>
                            <th class="px-8 py-5">{{ $title == 'Docs reçus' ? 'Envoyé par' : 'Destinataire' }}</th>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm">
                        @forelse($documents as $doc)
                        <tr class="hover:bg-slate-800/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-500/10 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-slate-200 uppercase tracking-tight">{{ $doc->title }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-400 font-medium">
                                {{ $title == 'Docs reçus' ? $doc->sender->name : $doc->receiver->name }}
                            </td>
                            <td class="px-8 py-5 text-slate-400 font-mono text-xs italic">
                                {{ $doc->created_at->format('d/m/Y à H:i') }}
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('documents.download', $doc) }}" class="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-black text-xs uppercase tracking-widest transition-all">
                                    Télécharger
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-500 italic">
                                Aucun document trouvé dans cette section.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>