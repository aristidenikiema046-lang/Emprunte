<section class="relative bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
    {{-- Décoration d'arrière-plan pour le relief --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#1a3a3a]/5 rounded-full blur-3xl -z-10"></div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('patch')

        {{-- 1. HEADER & AVATAR MIX --}}
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="relative group">
                <div class="w-40 h-40 rounded-[2.5rem] rotate-3 group-hover:rotate-0 transition-all duration-500 border-[6px] border-white shadow-2xl overflow-hidden bg-[#1a3a3a]">
                    <img id="preview"
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1a3a3a&color=fff' }}"
                         class="w-full h-full object-cover scale-110 group-hover:scale-100 transition-transform duration-500">
                </div>
                <label for="avatar" class="absolute -bottom-4 -right-4 bg-white text-[#1a3a3a] p-4 rounded-2xl shadow-xl cursor-pointer hover:bg-[#1a3a3a] hover:text-white transition-all duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-camera-rotate text-xl"></i>
                </label>
                <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
            </div>

            <div class="text-center md:text-left space-y-2">
                <span class="px-4 py-1 bg-[#1a3a3a]/10 text-[#1a3a3a] text-[10px] font-black uppercase tracking-[0.2em] rounded-full">Paramètres du compte</span>
                <h2 class="text-4xl font-black text-[#1a3a3a] tracking-tighter uppercase leading-tight">Mettre à jour <br>mon profil</h2>
                <p class="text-gray-400 font-medium max-w-sm">Optimisez votre visibilité au sein de l'entreprise en gardant vos informations à jour.</p>
            </div>
        </div>

        {{-- 2. GRILLE D'INFORMATIONS AVEC EFFET GLASSMORPHISM --}}
        <div class="bg-white/60 backdrop-blur-xl rounded-[3rem] p-10 shadow-2xl shadow-gray-200/50 border border-white space-y-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

                {{-- Champ Nom Complet --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1 group-focus-within:text-[#1a3a3a] transition-colors">Nom Complet</label>
                    <div class="relative">
                        <i class="fa-regular fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#1a3a3a]"></i>
                        <input id="name" name="name" type="text" class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-bold text-gray-700 placeholder-gray-300 transition-all" value="{{ old('name', $user->name) }}" required />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Champ Email Pro --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1 group-focus-within:text-[#1a3a3a] transition-colors">Email Pro</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#1a3a3a]"></i>
                        <input id="email" name="email" type="email" class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-bold text-gray-700 transition-all" value="{{ old('email', $user->email) }}" required />
                    </div>
                </div>

                {{-- Champ Contact Mobile --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1 group-focus-within:text-[#1a3a3a] transition-colors">Contact Mobile</label>
                    <div class="relative">
                        <i class="fa-solid fa-mobile-screen absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#1a3a3a]"></i>
                        <input id="phone" name="phone" type="text" class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-bold text-gray-700 transition-all" value="{{ old('phone', $user->phone) }}" />
                    </div>
                </div>

                {{-- Champ Genre --}}
                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1 group-focus-within:text-[#1a3a3a] transition-colors">Genre</label>
                    <div class="relative">
                        <i class="fa-solid fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#1a3a3a]"></i>
                        <select id="gender" name="gender" class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-bold text-gray-700 appearance-none transition-all">
                            <option value="Homme" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                            <option value="Femme" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                        </select>
                    </div>
                </div>

                {{-- Champ Adresse de résidence (Pleine largeur) --}}
                <div class="md:col-span-2 group">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1 group-focus-within:text-[#1a3a3a] transition-colors">Adresse de résidence</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#1a3a3a]"></i>
                        <input id="address" name="address" type="text" class="w-full pl-12 pr-4 py-4 bg-gray-50/50 border-none rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-bold text-gray-700 transition-all" value="{{ old('address', $user->address) }}" placeholder="Localisation précise..." />
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- 3. SECTION ADMINISTRATIVE & D'URGENCE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#1a3a3a] flex items-center gap-3">
                        <span class="w-6 h-[2px] bg-[#1a3a3a]"></span>
                        Vie Privée
                    </h3>
                    <div class="space-y-4">
                        <input id="family_status" name="family_status" type="text" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-bold text-sm shadow-sm transition-all" value="{{ old('family_status', $user->family_status) }}" placeholder="Situation familiale" />
                        <input id="cnps_number" name="cnps_number" type="text" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-[#1a3a3a]/5 font-black text-sm shadow-sm font-mono transition-all" value="{{ old('cnps_number', $user->cnps_number) }}" placeholder="N° CNPS" />
                    </div>
                </div>

                {{-- Contact d'Urgence --}}
                <div class="space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#1a3a3a] flex items-center gap-3">
                        <span class="w-6 h-[2px] bg-[#1a3a3a]"></span>
                        Urgence (Sécurité)
                    </h3>
                    <div class="p-6 bg-[#1a3a3a] rounded-[2rem] shadow-xl shadow-[#1a3a3a]/20 space-y-4">
                        <input name="emergency_contact_name" type="text" placeholder="Nom du contact" class="w-full px-5 py-3 bg-white/10 border-none rounded-xl focus:ring-2 focus:ring-white/30 text-white placeholder-white/40 font-bold text-sm transition-all" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" />
                        <div class="grid grid-cols-2 gap-3">
                            <input name="emergency_contact_phone" type="text" placeholder="Mobile" class="w-full px-5 py-3 bg-white/10 border-none rounded-xl focus:ring-2 focus:ring-white/30 text-white placeholder-white/40 font-bold text-sm transition-all" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" />
                            <input name="emergency_contact_relation" type="text" placeholder="Lien" class="w-full px-5 py-3 bg-white/10 border-none rounded-xl focus:ring-2 focus:ring-white/30 text-white placeholder-white/40 font-bold text-sm transition-all" value="{{ old('emergency_contact_relation', $user->emergency_contact_relation) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. FLOATING ACTION BAR POUR LA SAUVEGARDE --}}
        <div class="sticky bottom-8 flex items-center justify-between p-4 bg-[#1a3a3a] rounded-[2rem] shadow-2xl shadow-[#1a3a3a]/40 group transition-all duration-500 hover:scale-[1.02]">
            <div class="pl-6">
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-emerald-400 font-bold text-sm flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i> Modifications sauvées
                    </p>
                @else
                    <p class="text-white/50 text-xs font-black uppercase tracking-widest">Dernière vérification : {{ now()->format('H:i') }}</p>
                @endif
            </div>

            <button type="submit" class="px-10 py-4 bg-white text-[#1a3a3a] rounded-2xl font-black uppercase tracking-[0.15em] text-[10px] shadow-lg hover:bg-emerald-50 active:scale-95 transition-all">
                Mettre à jour le profil
            </button>
        </div>
    </form>
</section>

{{-- Script pour la prévisualisation de l'image et l'animation flash lors du changement --}}
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.parentElement.classList.add('animate-pulse');
            setTimeout(() => output.parentElement.classList.remove('animate-pulse'), 1000);
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>