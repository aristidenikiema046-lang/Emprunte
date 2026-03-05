<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Carte Header (Design Sombre & Immersif) --}}
        <div class="bg-[#111827] rounded-[3rem] overflow-hidden shadow-2xl border border-white/5 relative">
            {{-- Effets de lumière en fond --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full -mr-48 -mt-48 blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-500/5 rounded-full -ml-32 -mb-32 blur-[80px]"></div>
            
            <div class="p-10 flex flex-col md:flex-row items-center gap-10 relative z-10">
                {{-- Photo de profil Style "Performance" --}}
                <div class="relative">
                    <div class="w-40 h-40 rounded-[2.5rem] border-4 border-[#1f2937] overflow-hidden bg-slate-800 shadow-2xl group relative">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0d9488&color=fff&size=256" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <a href="{{ route('profile.edit') }}" class="absolute -bottom-2 -right-2 bg-blue-600 p-3.5 rounded-2xl shadow-xl hover:bg-blue-500 transition-all border-4 border-[#111827]">
                        <i class="fa-solid fa-pen text-white text-xs"></i>
                    </a>
                </div>

                {{-- Infos Nom/Poste --}}
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-4xl font-black text-white uppercase tracking-tighter">{{ $user->name }}</h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3">
                        <span class="text-teal-400 font-black text-xs uppercase tracking-[0.2em] bg-teal-500/10 px-4 py-1.5 rounded-xl border border-teal-500/20">
                            {{ $user->post ?? 'Développeur Laravel' }}
                        </span>
                        <span class="text-gray-500 font-black text-xs uppercase tracking-[0.2em] bg-white/5 px-4 py-1.5 rounded-xl border border-white/5">
                            {{ $user->department ?? 'Informatique' }}
                        </span>
                    </div>
                </div>

                {{-- Section Stats Badges --}}
                <div class="flex gap-4 w-full md:w-auto bg-[#0b0f1a] p-6 rounded-[2rem] border border-white/5 shadow-inner">
                    <div class="text-center px-6 border-r border-white/5">
                        <p class="text-white text-3xl font-black tracking-tighter">25.00</p>
                        <p class="text-gray-500 text-[9px] uppercase font-black tracking-[0.2em] mt-2">Congés</p>
                    </div>
                    <div class="text-center px-6">
                        <div class="flex items-center justify-center gap-2">
                            <span class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></span>
                            <p class="text-teal-500 text-xl font-black uppercase">Actif</p>
                        </div>
                        <p class="text-gray-500 text-[9px] uppercase font-black tracking-[0.2em] mt-2">Statut</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Colonne Gauche : Infos Personnelles --}}
            <div class="lg:col-span-7 bg-[#111827] rounded-[3rem] p-10 shadow-2xl border border-white/5">
                <div class="flex justify-between items-center mb-12">
                    <h3 class="text-white font-black text-xl uppercase tracking-tighter flex items-center gap-4">
                        <span class="w-1.5 h-8 bg-blue-600 rounded-full"></span>
                        Informations Personnelles
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-8">
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-black tracking-[0.3em] mb-2">Email professionnel</p>
                        <p class="text-white font-bold text-lg break-all">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-black tracking-[0.3em] mb-2">Téléphone</p>
                        <p class="text-white font-bold text-lg">{{ $user->phone ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-black tracking-[0.3em] mb-2">Genre</p>
                        <p class="text-white font-bold text-lg">{{ $user->gender ?? 'Non précisé' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-black tracking-[0.3em] mb-2">Situation Familiale</p>
                        <p class="text-white font-bold text-lg">{{ $user->family_status ?? 'Célibataire' }}</p>
                    </div>
                    <div class="col-span-2 p-6 bg-[#0b0f1a] rounded-[2rem] border border-white/5 shadow-inner">
                        <p class="text-gray-500 text-[10px] uppercase font-black tracking-[0.3em] mb-2">Adresse de résidence</p>
                        <p class="text-white font-bold italic leading-relaxed">{{ $user->address ?? 'Aucune adresse enregistrée' }}</p>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Urgence & RH --}}
            <div class="lg:col-span-5 space-y-8">
                
                {{-- Contact d'Urgence --}}
                <div class="bg-gradient-to-br from-rose-500/10 to-transparent rounded-[3rem] p-8 border border-rose-500/10 shadow-2xl">
                    <h3 class="text-rose-500 font-black text-sm uppercase tracking-[0.3em] mb-6">Contact d'Urgence</h3>
                    
                    @if($user->emergency_contact_name)
                        <div class="flex items-center gap-6 p-6 bg-[#0b0f1a] rounded-[2rem] border border-white/5 shadow-inner">
                            <div class="w-14 h-14 bg-rose-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-rose-500/20">
                                <i class="fa-solid fa-phone-flip"></i>
                            </div>
                            <div>
                                <p class="text-white font-black text-lg leading-tight uppercase">{{ $user->emergency_contact_name }}</p>
                                <p class="text-rose-400 font-bold text-sm mt-1 font-mono">{{ $user->emergency_contact_phone }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center p-6 border-2 border-dashed border-white/5 rounded-[2rem]">
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Aucun contact d'urgence</p>
                        </div>
                    @endif
                </div>

                {{-- Informations RH / Pro --}}
                <div class="bg-[#111827] rounded-[3rem] p-8 border border-white/5 shadow-2xl relative overflow-hidden">
                    <h3 class="text-blue-500 font-black text-sm uppercase tracking-[0.3em] mb-8">Données Administratives</h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center p-5 bg-[#0b0f1a] rounded-2xl border border-white/5">
                            <span class="text-gray-500 text-[10px] font-black uppercase tracking-widest">N° Employé</span>
                            <span class="text-white font-mono font-black text-lg">{{ $user->employee_id ?? 'EMP2026' }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-5 bg-[#0b0f1a] rounded-2xl border border-white/5">
                                <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest mb-1">Contrat</p>
                                <p class="text-teal-400 font-black">{{ $user->contract_type ?? 'Stage' }}</p>
                            </div>
                            <div class="p-5 bg-[#0b0f1a] rounded-2xl border border-white/5">
                                <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest mb-1">CNPS</p>
                                <p class="text-white font-black font-mono uppercase">{{ $user->cnps_number ?? '---' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-blue-500/5 rounded-2xl border border-blue-500/10">
                            <i class="fa-solid fa-lock text-blue-500 text-xs"></i>
                            <p class="text-[9px] text-gray-500 font-bold uppercase leading-tight tracking-tighter">
                                Données verrouillées par le service RH.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>