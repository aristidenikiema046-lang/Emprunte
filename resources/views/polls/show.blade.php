<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-white text-center">
        <div class="max-w-xl mx-auto px-4">
            <div class="bg-[#1e293b] p-10 rounded-[3rem] border border-slate-700 shadow-2xl">
                <h2 class="text-3xl font-black italic mb-4 tracking-tighter uppercase">{{ $poll->title }}</h2>
                <p class="text-slate-400 mb-10 italic">{{ $poll->description ?? 'Exprimez votre avis.' }}</p>

                <form action="{{ route('polls.vote', $poll) }}" method="POST" class="space-y-4 text-left">
                    @csrf
                    @foreach($poll->options as $option)
                        <label class="flex items-center justify-between p-5 bg-[#0f172a] border-2 border-slate-800 rounded-3xl cursor-pointer hover:border-indigo-500 transition-all group">
                            <span class="font-bold text-slate-300 group-hover:text-white">{{ $option }}</span>
                            <input type="radio" name="choice" value="{{ $option }}" class="w-6 h-6 text-indigo-600 bg-slate-900 border-slate-700 focus:ring-indigo-500" required>
                        </label>
                    @endforeach

                    <button type="submit" class="w-full mt-8 bg-indigo-600 hover:bg-indigo-500 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20">
                        Valider mon vote
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>