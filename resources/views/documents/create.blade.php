<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-[#1e293b] p-10 rounded-[2.5rem] border border-slate-800 shadow-2xl">
                <h2 class="text-2xl font-black italic mb-8 tracking-tighter uppercase">Envoyer un document</h2>

                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2 ml-1 italic">Titre</label>
                        <input type="text" name="title" placeholder="Ex: Contrat de mission" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white py-4 px-6 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2 ml-1 italic">Destinataire</label>
                        <select name="receiver_id" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white py-4 px-6 focus:ring-indigo-500 transition-all appearance-none" required>
                            <option value="">Choisir un collaborateur</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2 ml-1 italic">Fichier (max 10 Mo)</label>
                        <div class="relative group">
                            <input type="file" name="file" class="w-full text-sm text-slate-400 border border-slate-700 rounded-2xl p-2 file:mr-4 file:py-2 file:px-6 file:rounded-xl file:border-0 file:bg-indigo-600 file:text-white file:font-black file:uppercase file:cursor-pointer hover:file:bg-indigo-500 transition-all" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 pt-6">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 px-12 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                            Envoyer
                        </button>
                        <a href="{{ route('documents.sent') }}" class="text-slate-500 hover:text-white font-bold text-sm border-b border-transparent hover:border-white transition-all uppercase tracking-widest">
                            Mes envois
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>