<div class="max-w-4xl mx-auto space-y-8">
    <section class="bg-[#0f172a] rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        
        {{-- Header avec dégradé subtil --}}
        <div class="bg-gradient-to-r from-[#1e293b] to-[#0f172a] p-8 border-b border-white/5 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-white tracking-tight">Configuration Profil</h2>
                <p class="text-teal-400/60 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Édition des données sécurisées</p>
            </div>
            <div class="bg-teal-500/10 border border-teal-500/20 px-4 py-2 rounded-2xl">
                <i class="fa-solid fa-shield-halved text-teal-400 text-sm"></i>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8 space-y-10">
            @csrf
            @method('patch')

            {{-- Zone Avatar Modernisée --}}
            <div class="flex flex-col md:flex-row items-center gap-8 bg-white/5 p-6 rounded-[2rem] border border-white/5">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-blue-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative w-32 h-32">
                        <img id="preview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=14b8a6&color=fff' }}" 
                             class="w-full h-full rounded-3xl object-cover border-2 border-[#0f172a] shadow-2xl">
                        <label for="avatar" class="absolute -bottom-3 -right-3 bg-teal-500 text-[#0f172a] w-10 h-10 flex items-center justify-center rounded-2xl shadow-xl cursor-pointer hover:scale-110 transition-transform active:scale-95">
                            <i class="fa-solid fa-camera text-sm"></i>
                        </label>
                    </div>
                    <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
                </div>
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                    <p class="text-gray-400 text-sm mb-3">{{ $user->email }}</p>
                    <span class="px-4 py-1.5 bg-teal-500/10 text-teal-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-teal-500/20">
                        Collaborateur Actif
                    </span>
                </div>
            </div>

            {{-- Grille de Formulaire : Infos Personnelles --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                
                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Identité Complète</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-teal-400 transition-colors"></i>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}" 
                               class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 pl-12 pr-4 text-white font-bold focus:border-teal-500/50 focus:ring-0 transition-all" required>
                    </div>
                </div>

                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Adresse Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-teal-400 transition-colors"></i>
                        <input name="email" type="email" value="{{ old('email', $user->email) }}" 
                               class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 pl-12 pr-4 text-white font-bold focus:border-teal-500/50 focus:ring-0 transition-all" required>
                    </div>
                </div>

                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Contact Téléphonique</label>
                    <div class="relative">
                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-teal-400 transition-colors"></i>
                        <input name="phone" type="text" value="{{ old('phone', $user->phone) }}" 
                               class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 pl-12 pr-4 text-white font-bold focus:border-teal-500/50 focus:ring-0 transition-all">
                    </div>
                </div>

                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Genre</label>
                    <div class="relative">
                        <i class="fa-solid fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <select name="gender" class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 pl-12 pr-4 text-white font-bold focus:border-teal-500/50 focus:ring-0 appearance-none cursor-pointer">
                            <option value="Homme" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                            <option value="Femme" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Adresse Résidentielle</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-teal-400 transition-colors"></i>
                        <input name="address" type="text" value="{{ old('address', $user->address) }}" 
                               class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 pl-12 pr-4 text-white font-bold focus:border-teal-500/50 focus:ring-0 transition-all">
                    </div>
                </div>
            </div>

            {{-- Séparateur --}}
            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                <div class="relative flex justify-start"><span class="bg-[#0f172a] pr-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]">Urgence & Social</span></div>
            </div>

            {{-- Grille : Social & Urgence --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Situation Familiale</label>
                    <input name="family_status" type="text" value="{{ old('family_status', $user->family_status) }}" 
                           class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 px-6 text-white font-bold focus:border-teal-500/50 focus:ring-0 transition-all">
                </div>

                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-1">Numéro CNPS</label>
                    <input name="cnps_number" type="text" value="{{ old('cnps_number', $user->cnps_number) }}" 
                           class="w-full bg-[#1e293b]/50 border border-white/5 rounded-2xl py-4 px-6 text-teal-400 font-black tracking-widest focus:border-teal-500/50 focus:ring-0 transition-all">
                </div>

                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] ml-1">Contact d'Urgence (Nom)</label>
                    <input name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" 
                           class="w-full bg-rose-500/5 border border-rose-500/10 rounded-2xl py-4 px-6 text-white font-bold focus:border-rose-500/50 focus:ring-0 transition-all">
                </div>

                <div class="space-y-2 group">
                    <label class="block text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] ml-1">Contact d'Urgence (Tel)</label>
                    <input name="emergency_contact_phone" type="text" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" 
                           class="w-full bg-rose-500/5 border border-rose-500/10 rounded-2xl py-4 px-6 text-white font-bold focus:border-rose-500/50 focus:ring-0 transition-all">
                </div>
            </div>

            {{-- Bouton de validation --}}
            <div class="pt-6">
                <button type="submit" class="group relative w-full inline-flex items-center justify-center px-8 py-5 font-black text-[#0f172a] transition-all duration-200 bg-teal-400 rounded-2xl hover:bg-teal-300 active:scale-95 shadow-xl shadow-teal-500/20">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    ENREGISTRER LES MODIFICATIONS
                </button>
                
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="text-center text-teal-400 text-xs font-bold mt-6 animate-bounce">
                        <i class="fa-solid fa-circle-check mr-1"></i> Profil mis à jour avec succès !
                    </p>
                @endif
            </div>
        </form>
    </section>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>