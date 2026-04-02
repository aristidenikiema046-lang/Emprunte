<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-900 min-h-screen text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Formulaire --}}
                <div class="bg-slate-800 p-6 rounded-3xl border border-slate-700 h-fit">
                    <h3 class="text-lg font-bold mb-4 text-indigo-400">Demander un congé</h3>
                    <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-400">Type de congé</label>
                            <select name="type" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="Congé maladie">Congé maladie</option>
                                <option value="Personnel">Personnel</option>
                                <option value="Annuel">Annuel</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Début</label>
                                <input type="date" name="start_date" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Fin</label>
                                <input type="date" name="end_date" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400">Motif</label>
                            <textarea name="reason" rows="3" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Pourquoi demandez-vous ce congé ?" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400">Justificatif (Optionnel)</label>
                            <input type="file" name="attachment" class="mt-1 block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 py-3 rounded-xl font-bold hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">Envoyer la demande</button>
                    </form>
                </div>

                {{-- Liste --}}
                <div class="lg:col-span-2 bg-slate-800 p-6 rounded-3xl border border-slate-700 overflow-hidden">
                    <h3 class="text-lg font-bold mb-4">Mes demandes récentes</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[500px]">
                            <thead class="text-slate-500 border-b border-slate-700 text-xs uppercase">
                                <tr>
                                    <th class="pb-3">Type</th>
                                    <th class="pb-3">Période</th>
                                    <th class="pb-3 text-center">Doc</th>
                                    <th class="pb-3 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @forelse($leaves as $leave)
                                <tr>
                                    <td class="py-4 text-sm font-medium">{{ $leave->type }}</td>
                                    <td class="py-4 text-sm text-slate-400 whitespace-nowrap">Du {{ $leave->start_date }} au {{ $leave->end_date }}</td>
                                    <td class="py-4 text-center">
                                        @if($leave->attachment)
                                            <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300">
                                                <i class="fa-solid fa-paperclip"></i>
                                            </a>
                                        @else
                                            <span class="text-slate-600">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap
                                            {{ $leave->status == 'approuvé' ? 'bg-green-500/20 text-green-400' : 
                                               ($leave->status == 'refusé' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                                            {{ ucfirst($leave->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-10 text-center text-slate-500 italic">Aucune demande enregistrée.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>