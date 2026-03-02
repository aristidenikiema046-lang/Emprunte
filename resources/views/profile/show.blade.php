<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Carte Header (Identité Visuelle Forte) --}}
        <div class="bg-[#1a3a3a] rounded-[2rem] overflow-hidden shadow-2xl border border-white/5 relative">
            {{-- Décoration subtile en arrière-plan --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            
            <div class="p-8 flex flex-col md:flex-row items-center gap-8 relative z-10">
                {{-- Photo de profil --}}
                <div class="relative">
                    <div class="w-32 h-32 rounded-full border-4 border-white/20 overflow-hidden bg-slate-800 shadow-2xl transition-transform hover:scale-105 duration-300">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=128" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <a href="{{ route('profile.edit') }}" class="absolute bottom-1 right-1 bg-white p-2.5 rounded-full shadow-xl hover:bg-gray-100 transition-all group">
                        <i class="fa-solid fa-camera text-[#1a3a3a] text-sm group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>

                {{-- Infos Nom/Poste --}}
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">{{ $user->name }}</h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-2">
                        <span class="text-emerald-400 font-bold tracking-wide">{{ $user->post ?? 'Développeur Laravel' }}</span>
                        <span class="text-white/30 hidden md:inline">|</span>
                        <span class="text-gray-400 font-medium">{{ $user->department ?? 'Informatique' }}</span>
                    </div>
                </div>

                {{-- Section Badges (Stats) --}}
                <div class="flex gap-4 w-full md:w-auto bg-black/20 backdrop-blur-md p-5 rounded-[1.5rem] border border-white/10">
                    <div class="text-center px-4 border-r border-white/10">
                        <p class="text-white text-2xl font-black leading-none">25.00</p>
                        <p class="text-gray-400 text-[9px] uppercase font-black tracking-widest mt-2">Congés</p>
                    </div>
                    <div class="text-center px-4 border-r border-white/10">
                        <p class="text-white text-2xl font-black leading-none">0</p>
                        <p class="text-gray-400 text-[9px] uppercase font-black tracking-widest mt-2">Ancienneté</p>
                    </div>
                    <div class="text-center px-4">
                        <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded-md text-[10px] font-black uppercase ring-1 ring-emerald-500/30">Actif</span>
                        <p class="text-gray-400 text-[9px] uppercase font-black tracking-widest mt-2">Statut</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Colonne Gauche : Infos Personnelles --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-[#1a3a3a] font-black text-xl uppercase tracking-tight flex items-center gap-3">
                        <span class="w-2 h-8 bg-[#1a3a3a] rounded-full"></span>
                        Informations Personnelles
                    </h3>
                    <a href="{{ route('profile.edit') }}" class="p-2 hover:bg-gray-50 rounded-xl transition-colors">
                        <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-4 flex-1">
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">Nom complet</p>
                        <p class="text-gray-900 font-extrabold text-lg">{{ $user->name }}</p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">Email professionnel</p>
                        <p class="text-gray-900 font-extrabold text-lg truncate">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">Téléphone</p>
                        <p class="text-gray-800 font-bold">{{ $user->phone ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">Genre</p>
                        <p class="text-gray-800 font-bold">{{ $user->gender ?? 'Non précisé' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">Adresse de résidence</p>
                        <p class="text-gray-800 font-bold italic">{{ $user->address ?? 'Aucune adresse enregistrée' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">Situation Familiale</p>
                        <p class="text-gray-800 font-bold">{{ $user->family_status ?? 'Célibataire' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest mb-1">N° CNPS</p>
                        <p class="text-gray-800 font-mono font-black tracking-tighter">{{ $user->cnps_number ?? '--- --- ---' }}</p>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Urgence & Pro --}}
            <div class="space-y-8">
                
                {{-- Contact d'Urgence (Focus visuel) --}}
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-[2rem] p-8 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-[#1a3a3a] font-black text-xl uppercase tracking-tight">Contact d'Urgence</h3>
                        <i class="fa-solid fa-suitcase-medical text-red-500/20 text-2xl"></i>
                    </div>
                    
                    @if($user->emergency_contact_name)
                        <div class="flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="w-14 h-14 bg-[#1a3a3a] text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-[#1a3a3a]/20">
                                <i class="fa-solid fa-phone-flip"></i>
                            </div>
                            <div>
                                <p class="text-[#1a3a3a] font-black text-lg leading-tight">{{ $user->emergency_contact_name }}</p>
                                <p class="text-gray-500 font-bold text-sm mt-1">{{ $user->emergency_contact_phone }}</p>
                                <span class="inline-block mt-1 text-[10px] font-black uppercase px-2 py-0.5 bg-gray-100 text-gray-500 rounded">{{ $user->emergency_contact_relation }}</span>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('profile.edit') }}" class="group block border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-blue-400 transition-all">
                            <i class="fa-solid fa-circle-plus text-gray-300 text-3xl group-hover:text-blue-500 transition-colors"></i>
                            <p class="text-gray-400 font-bold mt-2">Ajouter un contact d'urgence</p>
                        </a>
                    @endif
                </div>

                {{-- Informations Professionnelles --}}
                <div class="bg-[#f8fafb] rounded-[2rem] p-8 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <i class="fa-solid fa-id-card text-8xl"></i>
                    </div>

                    <h3 class="text-[#1a3a3a] font-black text-xl uppercase tracking-tight mb-8">Informations Professionnelles</h3>
                    
                    <div class="space-y-6 relative z-10">
                        <div class="flex justify-between items-end border-b border-gray-200 pb-4">
                            <div>
                                <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest">Numéro employé</p>
                                <p class="text-[#1a3a3a] font-black text-xl">{{ $user->employee_id ?? 'EMP20260002' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-400 text-[10px] uppercase font-black tracking-widest">Type de contrat</p>
                                <p class="text-gray-800 font-bold uppercase">{{ $user->contract_type ?? 'Stage' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-50">
                                <p class="text-gray-400 text-[9px] uppercase font-black tracking-widest">Date d'embauche</p>
                                <p class="text-gray-800 font-extrabold">{{ $user->hire_date ? $user->hire_date->format('d/m/Y') : '07/02/2026' }}</p>
                            </div>
                            <div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-50">
                                <p class="text-gray-400 text-[9px] uppercase font-black tracking-widest">Fin de contrat</p>
                                <p class="text-gray-800 font-extrabold">{{ $user->end_date ?? 'CDI' }}</p>
                            </div>
                        </div>

                        <div class="bg-[#1a3a3a]/5 p-4 rounded-xl">
                            <p class="text-[10px] text-[#1a3a3a]/60 font-bold italic leading-tight">
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Ces informations sont gérées par les RH. Pour toute modification, veuillez contacter l'administration.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Section Sécurité --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-black text-sm uppercase tracking-tight">Sécurité du compte</p>
                            <p class="text-gray-400 text-[11px] font-medium">Mot de passe modifié il y a 5 jours</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-black text-xs uppercase tracking-widest transition-colors">
                        Gérer
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>