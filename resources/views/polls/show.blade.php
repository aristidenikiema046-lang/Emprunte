<x-app-layout>
    <div class="py-12 min-h-screen text-slate-200" style="background-color: #020617;">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <a href="{{ route('polls.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-indigo-400 transition-colors mb-8">
                <i class="fa-solid fa-arrow-left-long"></i> Retour à la liste
            </a>

            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 mb-6">
                    <i class="fa-solid fa-square-poll-vertical text-2xl text-indigo-500"></i>
                </div>
                <h2 class="text-3xl font-black italic tracking-tighter text-white uppercase">
                    {{ $poll->title }}
                </h2>
                @if($poll->description)
                    <p class="text-sm text-gray-500 mt-4 leading-relaxed italic">
                        "{{ $poll->description }}"
                    </p>
                @endif
            </div>

            <form action="{{ route('polls.vote', $poll) }}" method="POST" class="space-y-4">
                @csrf
                <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-8 shadow-2xl overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-6 opacity-5">
                        <i class="fa-solid fa-vote-yea text-6xl text-white"></i>
                    </div>

                    <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-8">Sélectionnez votre réponse :</label>

                    <div class="grid gap-4">
                        @foreach($poll->options as $option)
                            <label class="relative flex items-center group cursor-pointer">
                                <input type="radio" name="choice" value="{{ $option }}" required class="peer hidden">
                                <div class="w-full bg-gray-950 border border-gray-800 rounded-2xl p-5 flex items-center justify-between transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-500/5 group-hover:border-gray-700">
                                    <span class="text-sm font-bold text-gray-400 peer-checked:text-white transition-colors">{{ $option }}</span>
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-800 flex items-center justify-center peer-checked:border-indigo-500 transition-all">
                                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-500 scale-0 peer-checked:scale-100 transition-transform"></div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20 active:scale-[0.98] flex items-center justify-center gap-3">
                        Confirmer mon vote
                        <i class="fa-solid fa-check-double"></i>
                    </button>
                    <p class="text-center text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-6 italic">
                        <i class="fa-solid fa-shield-halved mr-1"></i> Vote anonyme & définitif
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>