<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed bottom-10 right-10 z-[100] max-w-sm w-full bg-gray-900 border border-white/10 rounded-[2rem] shadow-2xl overflow-hidden pointer-events-auto ring-1 ring-black ring-opacity-5">
    
    <div class="p-4">
        <div class="flex items-center gap-4">
            {{-- Icône dynamique selon le type --}}
            <div class="flex-shrink-0">
                @if(session('success'))
                    <div class="p-3 bg-emerald-500/10 rounded-2xl border border-emerald-500/20">
                        <i class="fa-solid fa-check-double text-emerald-500"></i>
                    </div>
                @else
                    <div class="p-3 bg-red-500/10 rounded-2xl border border-red-500/20">
                        <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                    </div>
                @endif
            </div>

            <div class="flex-1">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] {{ session('success') ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ session('success') ? 'Succès Système' : 'Alerte Système' }}
                </p>
                <p class="text-xs font-bold text-slate-300 mt-1">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>

            <button @click="show = false" class="text-gray-600 hover:text-white transition-colors px-2">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    </div>
    {{-- Barre de progression de temps --}}
    <div class="h-1 {{ session('success') ? 'bg-emerald-500' : 'bg-red-500' }} opacity-30 animate-[progress_5s_linear_forwards]"></div>
</div>

<style>
    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>