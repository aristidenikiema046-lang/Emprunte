<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Carte Header (Style Vert Sombre) --}}
        <div class="bg-[#1a3a3a] rounded-[2rem] overflow-hidden shadow-xl border border-white/5">
            <div class="p-8 flex flex-col md:flex-row items-center gap-8">
                {{-- Photo de profil avec bouton Camera --}}
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-4 border-white/10 overflow-hidden bg-gray-800 shadow-2xl">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&size=128" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Bouton Appareil Photo (Lien vers Edit) --}}
                    <a href="{{ route('profile.edit') }}" class="absolute bottom-1 right-1 bg-white p-2 rounded-full shadow-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fa-solid fa-camera text-gray-800 text-sm"></i>
                    </a>
                </div>

                {{-- Infos Rapides --}}
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-3xl font-black text-white uppercase tracking-tight">{{ $user->name }}</h2>
                    <p class="text-gray-300 font-medium text-lg">{{ $user->post ?? 'Poste non défini' }}</p>
                    <p class="text-gray-400 text-sm opacity-80">{{ $user->department ?? 'Département' }}</p>
                </div>

                {{-- Badges Statuts --}}
                <div class="grid grid-cols-3 gap-4 w-full md:w-auto bg-white/5 backdrop-blur-sm p-4 rounded-2xl">
                    <div class="text-center px-4 border-r border-white/10">
                        <p class="text-white text-xl font-black">25.00</p>
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Congés restants</p>
                    </div>
                    <div class="text-center px-4 border-r border-white/10">
                        <p class="text-white text-xl font-black">0</p>
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Années d'ancienneté</p>
                    </div>
                    <div class="text-center px-4">
                        <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-[10px] font-black uppercase">Actif</span>
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest mt-1">Statut</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Section 1 : Informations Personnelles --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-gray-900 font-black text-xl tracking-tight">Informations Personnelles</h3>
                    <a href="{{ route('profile.edit') }}" class="text-blue-600 font-bold text-sm flex items-center gap-2 hover:underline">
                        <i class="fa-solid fa-pen"></i> Modifier
                    </a>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Nom complet</p>
                        <p class="text-gray-800 font-bold text-lg">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Email</p>
                        <p class="text-gray-800 font-bold text-lg">{{ $user->email }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Téléphone</p>
                            <p class="text-gray-800 font-bold">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Genre</p>
                            <p class="text-gray-800 font-bold">{{ $user->gender ?? '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Date de naissance</p>
                        <p class="text-gray-800 font-bold">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Adresse</p>
                        <p class="text-gray-800 font-bold">{{ $user->address ?? '-' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Situation Familiale</p>
                            <p class="text-gray-800 font-bold">{{ $user->family_status ?? 'Célibataire (0 enfants)' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Numéro CNPS</p>
                            <p class="text-gray-800 font-bold">{{ $user->cnps_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Section 2 : Contact d'Urgence --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-gray-900 font-black text-xl tracking-tight">Contact d'Urgence</h3>
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 font-bold text-sm flex items-center gap-2">
                            <i class="fa-solid fa-pen"></i> Modifier
                        </a>
                    </div>
                    
                    @if($user->emergency_contact_name)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <p class="text-gray-900 font-black">{{ $user->emergency_contact_name }}</p>
                                <p class="text-gray-500 text-sm font-medium">{{ $user->emergency_contact_phone }} ({{ $user->emergency_contact_relation }})</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-gray-200">
                                <i class="fa-solid fa-life-ring text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 text-sm mb-4">Aucun contact d'urgence renseigné</p>
                            <a href="{{ route('profile.edit') }}" class="text-blue-600 font-black text-xs uppercase tracking-widest">Ajouter un contact</a>
                        </div>
                    @endif
                </div>

                {{-- Section 3 : Informations Professionnelles (Lecture seule) --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-gray-900 font-black text-xl tracking-tight mb-8">Informations Professionnelles</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Numéro employé</p>
                            <p class="text-gray-800 font-bold text-lg">{{ $user->employee_id ?? 'EMP' . date('Y') . '0001' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Département</p>
                                <p class="text-gray-800 font-bold">{{ $user->department ?? 'Non défini' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Poste</p>
                                <p class="text-gray-800 font-bold">{{ $user->post ?? 'Collaborateur' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Type de contrat</p>
                                <p class="text-gray-800 font-bold">{{ $user->contract_type ?? 'CDI' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-[11px] uppercase font-black tracking-widest">Date d'embauche</p>
                                <p class="text-gray-800 font-bold">{{ $user->hire_date ? $user->hire_date->format('d/m/Y') : '-' }}</p>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400 italic pt-4 border-t border-gray-100">
                            Ces informations sont gérées par les RH et ne peuvent pas être modifiées.
                        </p>
                    </div>
                </div>

                {{-- Section Sécurité --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-gray-900 font-black text-xl tracking-tight mb-6">Sécurité</h3>
                    <div class="bg-gray-50 rounded-2xl p-6 flex justify-between items-center">
                        <div>
                            <p class="text-gray-900 font-black">Mot de passe</p>
                            <p class="text-gray-500 text-xs">Dernière modification : il y a quelques jours</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="bg-white px-6 py-3 rounded-xl shadow-sm border border-gray-100 font-bold text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            Modifier
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>