<div class="max-w-6xl mx-auto">
    <section class="bg-[#111827] rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        
        {{-- Header Style "Performance" --}}
        <div class="bg-[#1e293b]/30 p-8 border-b border-white/5 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Configuration <span class="text-blue-500">Profil</span></h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="h-1 w-8 bg-teal-500 rounded-full"></span>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.3em]">Édition des données sécurisées</p>
                </div>
            </div>
            <div class="bg-teal-500/10 border border-teal-500/20 px-4 py-2 rounded-2xl">
                <i class="fa-solid fa-user-gear text-teal-400 text-sm"></i>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8 space-y-10">
            @csrf
            @method('patch')

            {{-- Zone Avatar Modernisée --}}
            <div class="flex flex-col md:flex-row items-center gap-8 bg-[#0b0f1a]/50 p-6 rounded-[2rem] border border-white/5 shadow-inner">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-blue-600 rounded-[2.5rem] blur opacity-25"></div>
                    <div class="relative w-32 h-32">
                        <img id="preview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=14b8a6&color=fff' }}" 
                             class="w-full h-full rounded-[2.2rem] object-cover border-4 border-[#111827] shadow-2xl">
                        <label for="avatar" class="absolute -bottom-2 -right-2 bg-blue-600 text-white w-10 h-10 flex items-center justify-center rounded-2xl shadow-xl cursor-pointer hover:scale-110 transition-transform">
                            <i class="fa-solid fa-camera text-sm"></i>
                        </label>
                    </div>
                    <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
                </div>
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">{{ $user->name }}</h3>
                    <p class="text-gray-500 text-xs font-bold mb-3 uppercase tracking-widest">{{ $user->email }}</p>
                    <span class="px-4 py-1.5 bg-teal-500/10 text-teal-400 text-[9px] font-black uppercase tracking-[0.2em] rounded-full border border-teal-500/20">
                        Collaborateur Actif
                    </span>
                </div>
            </div>

            {{-- Grille de Formulaire --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                
                {{-- Identité --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Identité Complète</label>
                    <input name="name" type="text" value="{{ old('name', $user->name) }}" 
                           class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-teal-500/20 transition-all" required>
                </div>

                {{-- Email --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Adresse Email</label>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}" 
                           class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-teal-500/20 transition-all" required>
                </div>

                {{-- Téléphone --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Contact Téléphonique</label>
                    <input name="phone" type="text" value="{{ old('phone', $user->phone) }}" 
                           class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-teal-500/20 transition-all">
                </div>

                {{-- Genre --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Genre</label>
                    <select name="gender" class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-teal-500/20 transition-all appearance-none cursor-pointer">
                        <option value="Homme" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                        <option value="Femme" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                    </select>
                </div>

                {{-- Adresse --}}
                <div class="md:col-span-2 space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Adresse Résidentielle</label>
                    <input name="address" type="text" value="{{ old('address', $user->address) }}" 
                           class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-teal-500/20 transition-all">
                </div>
            </div>

            {{-- Séparateur --}}
            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                <div class="relative flex justify-start">
                    <span class="bg-[#111827] pr-4 text-[10px] font-black text-rose-500 uppercase tracking-[0.3em]">Urgence & Social</span>
                </div>
            </div>

            {{-- Grille Sociale --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Situation Familiale</label>
                    <input name="family_status" type="text" value="{{ old('family_status', $user->family_status) }}" 
                           class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner transition-all">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-teal-400 uppercase tracking-[0.2em] ml-2">Numéro CNPS</label>
                    <input name="cnps_number" type="text" value="{{ old('cnps_number', $user->cnps_number) }}" 
                           class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-teal-400 font-black tracking-widest shadow-inner transition-all">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] ml-2">Contact Urgence (Nom)</label>
                    <input name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" 
                           class="w-full bg-rose-500/5 border border-rose-500/10 rounded-2xl py-4 px-6 text-white font-bold shadow-inner transition-all">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] ml-2">Contact Urgence (Tel)</label>
                    <input name="emergency_contact_phone" type="text" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" 
                           class="w-full bg-rose-500/5 border border-rose-500/10 rounded-2xl py-4 px-6 text-white font-bold shadow-inner transition-all">
                </div>
            </div>

            {{-- Bouton --}}
            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-teal-500 hover:bg-teal-400 text-[#0f172a] font-black uppercase tracking-[0.3em] text-xs rounded-2xl shadow-xl shadow-teal-900/20 transition-all active:scale-95">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Enregistrer les modifications
                </button>
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