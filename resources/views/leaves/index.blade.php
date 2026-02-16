<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-slate-800 p-6 rounded-3xl border border-slate-700">
                    <h3 class="text-lg font-bold mb-4 text-indigo-400">Demander un congé</h3>
                    <form action="{{ route('leaves.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-400">Type de congé</label>
                            <select name="type" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white">
                                <option value="Congé maladie">Congé maladie</option>
                                <option value="Personnel">Personnel</option>
                                <option value="Annuel">Annuel</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Début</label>
                                <input type="date" name="start_date" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Fin</label>
                                <input type="date" name="end_date" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400">Motif</label>
                            <textarea name="reason" rows="3" class="mt-1 block w-full rounded-xl bg-slate-900 border-slate-700 text-white" placeholder="Pourquoi demandez-vous ce congé ?" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 py-3 rounded-xl font-bold hover:bg-indigo-500 transition">Envoyer la demande</button>
                    </form>
                </div>

                <div class="md:col-span-2 bg-slate-800 p-6 rounded-3xl border border-slate-700">
                    <h3 class="text-lg font-bold mb-4">Mes demandes récentes</h3>
                    <table class="w-full text-left">
                        <thead class="text-slate-500 border-b border-slate-700 text-xs uppercase">
                            <tr>
                                <th class="pb-3">Type</th>
                                <th class="pb-3">Période</th>
                                <th class="pb-3">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($leaves as $leave)
                            <tr>
                                <td class="py-4 text-sm">{{ $leave->type }}</td>
                                <td class="py-4 text-sm text-slate-400">Du {{ $leave->start_date }} au {{ $leave->end_date }}</td>
                                <td class="py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                        {{ $leave->status == 'approuvé' ? 'bg-green-500/20 text-green-400' : 
                                           ($leave->status == 'refusé' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-slate-500 italic">Aucune demande pour le moment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>