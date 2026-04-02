<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Header Card --}}
        <div class="rounded-[2.5rem] sm:rounded-[3rem] overflow-hidden shadow-2xl border border-white/5 relative" style="background-color: #111827;">
            <div class="absolute top-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-blue-500/10 rounded-full blur-[80px] sm:blur-[100px]"></div>
            
            <div class="p-6 sm:p-10 flex flex-col md:flex-row items-center gap-6 sm:gap-10 relative z-10">
                <div class="relative group">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-[2rem] sm:rounded-[2.5rem] border-4 border-gray-800 overflow-hidden bg-slate-800 shadow-2xl">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0d9488&color=fff&size=256' }}" class="w-full h-full object-cover">
                    </div>
                    <a href="{{ route('profile.edit') }}" class="absolute -bottom-2 -right-2 bg-blue-600 p-2.5 sm:p-3 rounded-xl sm:rounded-2xl text-white shadow-xl hover:scale-110 transition-transform">
                        <i class="fa-solid fa-camera text-sm"></i>
                    </a>
                </div>

                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl sm:text-4xl font-black text-white uppercase tracking-tighter">{{ $user->name }}</h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                        <span class="text-teal-400 font-black text-[10px] uppercase bg-teal-500/10 px-4 py-1.5 rounded-xl border border-teal-500/20">
                            {{ $user->post ?? 'Collaborateur' }}
                        </span>
                        <a href="{{ route('profile.edit') }}" class="bg-white/5 text-gray-300 px-4 py-1.5 rounded-xl border border-white/10 text-[10px] font-bold uppercase hover:bg-white/10 transition">
                            <i class="fa-solid fa-pen mr-2"></i> Modifier
                        </a>
                    </div>
                </div>

                <div class="flex gap-2 sm:gap-4 bg-[#0b0f1a] p-4 sm:p-6 rounded-[1.5rem] sm:rounded-[2rem] border border-white/5 w-full md:w-auto justify-center" style="background-color: #0b0f1a;">
                    <div class="text-center px-4 sm:px-6 border-r border-white/5">
                        <p class="text-white text-xl sm:text-3xl font-black tracking-tighter italic">25.00</p>
                        <p class="text-gray-500 text-[8px] sm:text-[9px] uppercase font-black mt-1 sm:mt-2">Congés</p>
                    </div>
                    <div class="text-center px-4 sm:px-6">
                        <p class="text-teal-500 text-lg sm:text-xl font-black uppercase">Actif</p>
                        <p class="text-gray-500 text-[8px] sm:text-[9px] uppercase font-black mt-1 sm:mt-2">Statut</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
            {{-- Personal Info --}}
            <div class="lg:col-span-7 rounded-[2.5rem] sm:rounded-[3rem] p-6 sm:p-10 shadow-2xl border border-white/5" style="background-color: #111827;">
                <h3 class="text-white font-black text-lg sm:text-xl uppercase tracking-tighter flex items-center gap-4 mb-8 sm:mb-10">
                    <span class="w-1.5 h-6 sm:h-8 bg-blue-600 rounded-full"></span>
                    Informations Personnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-10">
                    <div class="break-words">
                        <p class="text-gray-500 text-[9px] sm:text-[10px] uppercase font-black mb-2 tracking-widest">Email professionnel</p>
                        <p class="text-white font-bold text-base sm:text-lg">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[9px] sm:text-[10px] uppercase font-black mb-2 tracking-widest">Téléphone</p>
                        <p class="text-white font-bold text-base sm:text-lg">{{ $user->phone ?? 'Non renseigné' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500 text-[9px] sm:text-[10px] uppercase font-black mb-2 tracking-widest">Adresse de résidence</p>
                        <p class="text-white font-bold text-base sm:text-lg">{{ $user->address ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            {{-- Admin Info --}}
            <div class="lg:col-span-5 rounded-[2.5rem] sm:rounded-[3rem] p-6 sm:p-10 shadow-2xl border border-white/5" style="background-color: #111827;">
                <h3 class="text-blue-500 font-black text-xs sm:text-sm uppercase mb-6 sm:mb-8 tracking-widest">Données Administratives</h3>
                <div class="space-y-4">
                    <div class="p-4 sm:p-5 bg-[#0b0f1a] rounded-2xl border border-white/5 flex justify-between items-center">
                        <span class="text-gray-500 text-[9px] sm:text-[10px] font-black uppercase">N° Employé</span>
                        <span class="text-white font-mono font-black text-sm">{{ $user->employee_id ?? 'EMP2026' }}</span>
                    </div>
                    <div class="p-4 sm:p-5 bg-[#0b0f1a] rounded-2xl border border-white/5 flex justify-between items-center">
                        <span class="text-gray-500 text-[9px] sm:text-[10px] font-black uppercase">Genre</span>
                        <span class="text-white font-black uppercase text-[10px] sm:text-xs">{{ $user->gender ?? '---' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>