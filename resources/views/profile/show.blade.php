<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="rounded-[3rem] overflow-hidden shadow-2xl border border-white/5 relative" style="background-color: #111827;">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px]"></div>
            
            <div class="p-10 flex flex-col md:flex-row items-center gap-10 relative z-10">
                <div class="relative group">
                    <div class="w-40 h-40 rounded-[2.5rem] border-4 border-gray-800 overflow-hidden bg-slate-800 shadow-2xl">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0d9488&color=fff&size=256' }}" class="w-full h-full object-cover">
                    </div>
                    <a href="{{ route('profile.edit') }}" class="absolute -bottom-2 -right-2 bg-blue-600 p-3 rounded-2xl text-white shadow-xl hover:scale-110 transition-transform">
                        <i class="fa-solid fa-camera"></i>
                    </a>
                </div>

                <div class="text-center md:text-left flex-1">
                    <h2 class="text-4xl font-black text-white uppercase tracking-tighter">{{ $user->name }}</h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3">
                        <span class="text-teal-400 font-black text-xs uppercase bg-teal-500/10 px-4 py-1.5 rounded-xl border border-teal-500/20">
                            {{ $user->post ?? 'Collaborateur' }}
                        </span>
                        <a href="{{ route('profile.edit') }}" class="bg-white/5 text-gray-300 px-4 py-1.5 rounded-xl border border-white/10 text-xs font-bold uppercase hover:bg-white/10 transition">
                            <i class="fa-solid fa-pen mr-2"></i> Modifier mon profil
                        </a>
                    </div>
                </div>

                <div class="flex gap-4 bg-[#0b0f1a] p-6 rounded-[2rem] border border-white/5" style="background-color: #0b0f1a;">
                    <div class="text-center px-6 border-r border-white/5">
                        <p class="text-white text-3xl font-black tracking-tighter italic">25.00</p>
                        <p class="text-gray-500 text-[9px] uppercase font-black mt-2">Congés</p>
                    </div>
                    <div class="text-center px-6">
                        <p class="text-teal-500 text-xl font-black uppercase">Actif</p>
                        <p class="text-gray-500 text-[9px] uppercase font-black mt-2">Statut</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7 rounded-[3rem] p-10 shadow-2xl border border-white/5" style="background-color: #111827;">
                <h3 class="text-white font-black text-xl uppercase tracking-tighter flex items-center gap-4 mb-10">
                    <span class="w-1.5 h-8 bg-blue-600 rounded-full"></span>
                    Informations Personnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-black mb-2 tracking-widest">Email professionnel</p>
                        <p class="text-white font-bold text-lg">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-black mb-2 tracking-widest">Téléphone</p>
                        <p class="text-white font-bold text-lg">{{ $user->phone ?? 'Non renseigné' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500 text-[10px] uppercase font-black mb-2 tracking-widest">Adresse de résidence</p>
                        <p class="text-white font-bold text-lg">{{ $user->address ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 rounded-[3rem] p-10 shadow-2xl border border-white/5" style="background-color: #111827;">
                <h3 class="text-blue-500 font-black text-sm uppercase mb-8 tracking-widest">Données Administratives</h3>
                <div class="space-y-4">
                    <div class="p-5 bg-[#0b0f1a] rounded-2xl border border-white/5 flex justify-between items-center">
                        <span class="text-gray-500 text-[10px] font-black uppercase">N° Employé</span>
                        <span class="text-white font-mono font-black">{{ $user->employee_id ?? 'EMP2026' }}</span>
                    </div>
                    <div class="p-5 bg-[#0b0f1a] rounded-2xl border border-white/5 flex justify-between items-center">
                        <span class="text-gray-500 text-[10px] font-black uppercase">Genre</span>
                        <span class="text-white font-black uppercase text-xs">{{ $user->gender ?? '---' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>