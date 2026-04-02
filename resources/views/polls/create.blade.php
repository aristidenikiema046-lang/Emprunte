<x-app-layout>
    <div class="py-12 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <a href="{{ route('polls.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-indigo-400 transition-colors mb-8">
                <i class="fa-solid fa-arrow-left-long"></i> Retour
            </a>

            <div class="mb-10">
                <h2 class="text-3xl md:text-4xl font-black italic tracking-tighter text-white uppercase">
                    Lancer un <span class="text-indigo-500">Sondage</span>
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-2">
                    Espace Administrateur - Marcory ManageX
                </p>
            </div>

            <form action="{{ route('polls.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-gray-900 border border-gray-800 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 shadow-2xl">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-3">Titre du sondage</label>
                            <input type="text" name="title" required class="w-full bg-gray-950 border border-gray-800 rounded-xl px-5 py-4 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-bold" placeholder="Ex: Choix de la date du séminaire">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-3">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-gray-950 border border-gray-800 rounded-xl px-5 py-4 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium" placeholder="Précisions..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 shadow-2xl" x-data="{ options: ['', ''] }">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-6 flex justify-between items-center">
                        Options de réponse
                    </label>

                    <div class="space-y-4">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="flex gap-2 md:gap-3">
                                <input type="text" name="options[]" required class="flex-1 bg-gray-950 border border-gray-800 rounded-xl px-4 md:px-5 py-4 text-white focus:border-indigo-500 transition-all font-bold text-sm min-w-0" placeholder="Option">
                                <button type="button" @click="if(options.length > 2) options.splice(index, 1)" class="shrink-0 w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-950 border border-gray-800 text-rose-500 hover:bg-rose-500/10 transition-all">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="options.push('')" class="mt-6 w-full py-4 border-2 border-dashed border-gray-800 rounded-xl text-gray-500 hover:border-indigo-500/50 hover:text-indigo-400 transition-all text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2">
                        + Ajouter une option
                    </button>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20">
                    Diffuser le sondage
                </button>
            </form>
        </div>
    </div>
</x-app-layout>