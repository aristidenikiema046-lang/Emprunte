<x-app-layout>
    <div class="py-12 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <a href="{{ route('polls.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-indigo-400 transition-colors mb-8">
                <i class="fa-solid fa-arrow-left-long"></i> Retour aux sondages
            </a>

            <div class="mb-10">
                <h2 class="text-4xl font-black italic tracking-tighter text-white uppercase">
                    Nouveau <span class="text-indigo-500">Sondage</span>
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-2">
                    Configurez une question et ses options pour l'équipe
                </p>
            </div>

            <form action="{{ route('polls.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="bg-gray-900 border border-gray-800 rounded-[2rem] p-8 shadow-2xl">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-3">Titre du sondage</label>
                            <input type="text" name="title" required
                                   class="w-full bg-gray-950 border border-gray-800 rounded-xl px-5 py-4 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder:text-gray-700 font-bold"
                                   placeholder="Ex: Choix du prochain team building ?">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-3">Description (Optionnel)</label>
                            <textarea name="description" rows="3"
                                      class="w-full bg-gray-950 border border-gray-800 rounded-xl px-5 py-4 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder:text-gray-700 font-medium"
                                      placeholder="Donnez plus de contexte..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-[2rem] p-8 shadow-2xl" x-data="{ options: ['', ''] }">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-6 flex justify-between items-center">
                        Options de réponse
                        <span class="text-gray-600 normal-case italic font-medium">Minimum 2 options</span>
                    </label>

                    <div class="space-y-4">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="flex gap-3">
                                <div class="flex-1 relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-700" x-text="index + 1"></span>
                                    <input type="text" name="options[]" required
                                           class="w-full bg-gray-950 border border-gray-800 rounded-xl pl-10 pr-5 py-4 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-bold text-sm"
                                           placeholder="Entrez une option">
                                </div>
                                <button type="button" @click="if(options.length > 2) options.splice(index, 1)" 
                                        class="w-14 h-14 rounded-xl bg-gray-950 border border-gray-800 text-rose-500 hover:bg-rose-500/10 hover:border-rose-500/50 transition-all flex items-center justify-center">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="options.push('')" 
                            class="mt-6 w-full py-4 border-2 border-dashed border-gray-800 rounded-xl text-gray-500 hover:border-indigo-500/50 hover:text-indigo-400 transition-all text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Ajouter une option
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-paper-plane"></i> Publier le sondage
                    </button>
                    <a href="{{ route('polls.index') }}" class="px-8 py-5 bg-gray-800/50 text-gray-400 rounded-2xl font-black uppercase text-xs tracking-widest border border-gray-700 hover:bg-gray-700 hover:text-white transition-all text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>