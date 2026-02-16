<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-[#1e293b] p-8 rounded-[2.5rem] border border-slate-700 shadow-2xl">
                <h2 class="text-2xl font-black italic mb-8 tracking-tighter">Créer un sondage</h2>

                <form action="{{ route('polls.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2 ml-1">Titre</label>
                        <input type="text" name="title" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white focus:ring-indigo-500 py-3" placeholder="Ex: Satisfaction repas" required>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2 ml-1">Description (optionnel)</label>
                        <textarea name="description" rows="3" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white focus:ring-indigo-500"></textarea>
                    </div>

                    <div id="options-container" class="space-y-3">
                        <label class="block text-slate-400 text-sm font-bold mb-2 ml-1">Options (au moins 2)</label>
                        <input type="text" name="options[]" placeholder="Option 1" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white py-3" required>
                        <input type="text" name="options[]" placeholder="Option 2" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white py-3" required>
                    </div>

                    <button type="button" onclick="addOption()" class="mt-4 text-indigo-400 hover:text-indigo-300 text-sm font-bold flex items-center gap-2 transition-colors">
                        <span class="bg-indigo-500/10 p-1 rounded-lg">+</span> Ajouter une option
                    </button>

                    <div class="flex gap-4 pt-8">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 px-10 py-3 rounded-2xl font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20">
                            Enregistrer
                        </button>
                        <a href="{{ route('polls.index') }}" class="px-10 py-3 rounded-2xl font-bold text-slate-400 hover:text-white transition-colors">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addOption() {
            const container = document.getElementById('options-container');
            const inputCount = container.getElementsByTagName('input').length + 1;
            const div = document.createElement('div');
            div.className = "flex gap-2 animate-fadeIn";
            div.innerHTML = `
                <input type="text" name="options[]" placeholder="Option ${inputCount}" class="w-full bg-[#0f172a] border-slate-700 rounded-2xl text-white py-3 focus:ring-indigo-500">
            `;
            container.appendChild(div);
        }
    </script>
</x-app-layout>