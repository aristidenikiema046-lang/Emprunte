<section class="relative bg-[#1a202c] rounded-[2.5rem] p-10 shadow-2xl border border-white/5 overflow-hidden">
    {{-- Effet de lumière diffuse en arrière-plan --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] -z-10"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-600/5 rounded-full blur-[100px] -z-10"></div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('patch')

        {{-- 1. HEADER & AVATAR --}}
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="relative group">
                <div class="w-40 h-40 rounded-[2.5rem] rotate-3 group-hover:rotate-0 transition-all duration-500 border-[6px] border-[#2d3748] shadow-2xl overflow-hidden bg-[#2d3748]">
                    <img id="preview" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=3182ce&color=fff' }}" 
                         class="w-full h-full object-cover scale-110 group-hover:scale-100 transition-transform duration-500">
                </div>
                <label for="avatar" class="absolute -bottom-4 -right-4 bg-blue-600 text-white p-4 rounded-2xl shadow-xl cursor-pointer hover:bg-blue-500 transition-all duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-camera-rotate text-xl"></i>
                </label>
                <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
            </div>

            <div class="text-center md:text-left space-y-3">
                <span class="px-4 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-blue-500/20">Configuration</span>
                <h2 class="text-4xl font-black text-white tracking-tighter uppercase leading-tight">Modifier mon <br><span class="text-blue-500">Profil</span></h2>
                <p class="text-gray-400 font-medium max-w-sm">Ajustez vos accès et vos informations de contact professionnelles.</p>
            </div>
        </div>

        {{-- 2. PANNEAU DE SAISIE DARK --}}
        <div class="bg-[#2d3748]/30 backdrop-blur-md rounded-[3rem] p-10 border border-white/5 space-y-10">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                
                {{-- Nom Complet --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1 group-focus-within:text-blue-400 transition-colors">Nom Complet</label>
                    <div class="relative">
                        <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400"></i>
                        <input id="name" name="name" type="text" class="w-full pl-12 pr-4 py-4 bg-[#1a202c]/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/50 font-bold text-gray-200 placeholder-gray-600 transition-all" value="{{ old('name', $user->name) }}" required />
                    </div>
                </div>

                {{-- Email --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1 group-focus-within:text-blue-400 transition-colors">Email Professionnel</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400"></i>
                        <input id="email" name="email" type="email" class="w-full pl-12 pr-4 py-4 bg-[#1a202c]/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/50 font-bold text-gray-200 transition-all" value="{{ old('email', $user->email) }}" required />
                    </div>
                </div>

                {{-- Téléphone --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1 group-focus-within:text-blue-400 transition-colors">Téléphone</label>
                    <div class="relative">
                        <i class="fa-solid fa-phone-flip absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400"></i>
                        <input id="phone" name="phone" type="text" class="w-full pl-12 pr-4 py-4 bg-[#1a202c]/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/50 font-bold text-gray-200 transition-all" value="{{ old('phone', $user->phone) }}" />
                    </div>
                </div>

                {{-- Genre --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1 group-focus-within:text-blue-400 transition-colors">Genre</label>
                    <div class="relative">
                        <i class="fa-solid fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400"></i>
                        <select id="gender" name="gender" class="w-full pl-12 pr-4 py-4 bg-[#1a202c]/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/50 font-bold text-gray-200 appearance-none transition-all">
                            <option value="Homme" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                            <option value="Femme" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                        </select>
                    </div>
                </div>

                {{-- Adresse --}}
                <div class="md:col-span-2 group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1 group-focus-within:text-blue-400 transition-colors">Adresse de résidence</label>
                    <div class="relative">
                        <i class="fa-solid fa-map-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400"></i>
                        <input id="address" name="address" type="text" class="w-full pl-12 pr-4 py-4 bg-[#1a202c]/50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/50 font-bold text-gray-200 transition-all" value="{{ old('address', $user->address) }}" placeholder="Votre adresse complète..." />
                    </div>
                </div>
            </div>

            <div class="h-px bg-white/5 w-full"></div>

            {{-- 3. SECTION ADMINISTRATIVE & SECURITE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-blue-400 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-blue-500"></span> 
                        Documents
                    </h3>
                    <div class="space-y-4">
                        <input id="family_status" name="family_status" type="text" class="w-full px-6 py-4 bg-[#1a202c]/30 border border-white/5 rounded-2xl focus:ring-2 focus:ring-blue-500/50 text-gray-300 font-bold text-sm transition-all" value="{{ old('family_status', $user->family_status) }}" placeholder="Situation familiale" />
                        <input id="cnps_number" name="cnps_number" type="text" class="w-full px-6 py-4 bg-[#1a202c]/30 border border-white/5 rounded-2xl focus:ring-2 focus:ring-blue-500/50 text-gray-300 font-black text-sm font-mono transition-all" value="{{ old('cnps_number', $user->cnps_number) }}" placeholder="Numéro CNPS" />
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-red-400 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-red-500"></span> 
                        Contact d'Urgence
                    </h3>
                    <div class="p-6 bg-red-500/10 rounded-[2rem] border border-red-500/20 space-y-4">
                        <input name="emergency_contact_name" type="text" placeholder="Nom complet" class="w-full px-5 py-3 bg-[#1a202c]/60 border-none rounded-xl focus:ring-2 focus:ring-red-500/50 text-white placeholder-gray-600 font-bold text-sm transition-all" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" />
                        <div class="grid grid-cols-2 gap-3">
                            <input name="emergency_contact_phone" type="text" placeholder="Mobile" class="w-full px-5 py-3 bg-[#1a202c]/60 border-none rounded-xl focus:ring-2 focus:ring-red-500/50 text-white placeholder-gray-600 font-bold text-sm transition-all" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" />
                            <input name="emergency_contact_relation" type="text" placeholder="Lien" class="w-full px-5 py-3 bg-[#1a202c]/60 border-none rounded-xl focus:ring-2 focus:ring-red-500/50 text-white placeholder-gray-600 font-bold text-sm transition-all" value="{{ old('emergency_contact_relation', $user->emergency_contact_relation) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. FOOTER / ACTION --}}
        <div class="flex items-center justify-between p-2 bg-[#2d3748] rounded-[2rem] border border-white/5 shadow-xl">
            <div class="pl-6">
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i> Données synchronisées
                    </p>
                @endif
            </div>

            <button type="submit" class="px-12 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-blue-500/20 active:scale-95 transition-all">
                Sauvegarder les changements
            </button>
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.add('opacity-50');
            setTimeout(() => output.classList.remove('opacity-50'), 300);
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>