<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold italic">Mon Espace Travail</h1>
                <p class="text-slate-400">Bienvenue, {{ auth()->user()->name }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-[#1e293b] p-6 rounded-[2rem] border border-slate-700 shadow-xl flex flex-col items-center justify-center">
                    <p class="text-slate-400 text-xs uppercase font-black mb-2">Mon Score Global</p>
                    <div class="text-5xl font-black text-indigo-500">{{ $totalScore }}%</div>
                </div>

                <div class="bg-[#1e293b] p-6 rounded-[2rem] border border-slate-700 shadow-xl md:col-span-2">
                    <p class="text-slate-400 text-xs uppercase font-black mb-4">Progression des objectifs</p>
                    <div class="w-full bg-slate-900 rounded-full h-4 mb-2">
                        <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ $totalScore }}%"></div>
                    </div>
                    <p class="text-sm text-slate-400">{{ $completedTasksCount }} missions terminées sur {{ $myTasks->count() }}</p>
                </div>
            </div>

            <div class="bg-[#1e293b] rounded-[2rem] border border-slate-700 shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-700 bg-slate-900/50">
                    <h3 class="font-bold">Mes Missions Récentes</h3>
                </div>
                <div class="p-6">
                    @forelse($myTasks as $task)
                        <div class="flex items-center justify-between p-4 mb-3 bg-[#0f172a] rounded-2xl border border-slate-700">
                            <span class="{{ $task->is_completed ? 'line-through text-slate-500' : 'text-slate-200' }}">
                                {{ $task->title }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $task->is_completed ? 'bg-green-500/20 text-green-400' : 'bg-indigo-500/20 text-indigo-400' }}">
                                {{ $task->is_completed ? 'Terminé' : 'À faire' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-slate-500 italic">Aucune mission assignée pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>