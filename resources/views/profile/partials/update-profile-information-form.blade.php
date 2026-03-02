<section class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
    <header class="mb-8 border-b border-gray-100 pb-6">
        <h2 class="text-2xl font-black text-[#1a3a3a] uppercase tracking-tighter">
            {{ __('Paramètres du Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 font-medium">
            {{ __("Mettez à jour vos informations personnelles et votre photo d'identité.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        {{-- Zone d'Upload Photo Style Premium --}}
        <div class="flex flex-col md:flex-row items-center gap-8 p-6 bg-[#f8fafb] rounded-[1.5rem] border border-gray-100">
            <div class="relative group">
                <div class="w-28 h-28 rounded-2xl border-4 border-white overflow-hidden shadow-xl bg-[#1a3a3a]">
                    <img id="preview" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1a3a3a&color=fff' }}" 
                         class="w-full h-full object-cover">
                </div>
                <label for="avatar" class="absolute -bottom-2 -right-2 bg-[#1a3a3a] text-white p-2 rounded-lg shadow-lg cursor-pointer hover:scale-110 transition-transform">
                    <i class="fa-solid fa-camera text-xs"></i>
                </label>
                <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
            </div>
            
            <div class="text-center md:text-left">
                <h4 class="text-[#1a3a3a] font-black uppercase text-xs tracking-widest mb-1">Photo de profil</h4>
                <p class="text-gray-400 text-xs mb-3">Format JPG ou PNG. Maximum 2MB.</p>
                <button type="button" onclick="document.getElementById('avatar').click()" class="text-xs font-black uppercase tracking-widest text-blue-600 hover:text-blue-800 transition-colors">
                    Changer la photo
                </button>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- Grille de saisie --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            
            {{-- Nom --}}
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nom complet')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <input id="name" name="name" type="text" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm" value="{{ old('name', $user->name) }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Adresse Email')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <input id="email" name="email" type="email" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm" value="{{ old('email', $user->email) }}" required />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            {{-- Téléphone --}}
            <div class="space-y-2">
                <x-input-label for="phone" :value="__('Téléphone')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <input id="phone" name="phone" type="text" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm" value="{{ old('phone', $user->phone) }}" />
            </div>

            {{-- Genre --}}
            <div class="space-y-2">
                <x-input-label for="gender" :value="__('Genre')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <select id="gender" name="gender" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm">
                    <option value="Homme" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            {{-- Adresse (Pleine largeur) --}}
            <div class="md:col-span-2 space-y-2">
                <x-input-label for="address" :value="__('Adresse Résidentielle')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <input id="address" name="address" type="text" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm" value="{{ old('address', $user->address) }}" placeholder="Ex: Cocody, Angré 7ème Tranche" />
            </div>

            {{-- Situation Familiale --}}
            <div class="space-y-2">
                <x-input-label for="family_status" :value="__('Situation Familiale')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <input id="family_status" name="family_status" type="text" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm" value="{{ old('family_status', $user->family_status) }}" placeholder="Célibataire (0 enfants)" />
            </div>

            {{-- CNPS --}}
            <div class="space-y-2">
                <x-input-label for="cnps_number" :value="__('Numéro CNPS')" class="text-[#1a3a3a] font-black uppercase text-[10px] tracking-widest ml-1" />
                <input id="cnps_number" name="cnps_number" type="text" class="block w-full px-4 py-3 bg-[#f8fafb] border-gray-100 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] focus:border-[#1a3a3a] font-bold text-gray-700 transition-all shadow-sm font-mono" value="{{ old('cnps_number', $user->cnps_number) }}" />
            </div>
        </div>

        {{-- Contact d'Urgence --}}
        <div class="mt-10 p-6 border-2 border-dashed border-gray-100 rounded-[1.5rem] space-y-6">
            <h3 class="text-[#1a3a3a] font-black uppercase text-[11px] tracking-[0.2em] flex items-center gap-2">
                <i class="fa-solid fa-shield-heart text-red-500"></i>
                Contact d'Urgence
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input name="emergency_contact_name" type="text" placeholder="Nom du contact" class="block w-full px-4 py-3 bg-white border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] font-bold text-sm shadow-sm" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" />
                <input name="emergency_contact_phone" type="text" placeholder="Téléphone" class="block w-full px-4 py-3 bg-white border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] font-bold text-sm shadow-sm" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}" />
                <input name="emergency_contact_relation" type="text" placeholder="Lien (ex: Frère)" class="block w-full px-4 py-3 bg-white border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1a3a3a] font-bold text-sm shadow-sm" value="{{ old('emergency_contact_relation', $user->emergency_contact_relation) }}" />
            </div>
        </div>

        {{-- Bouton de validation --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 font-bold flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> Modifications enregistrées
                </p>
            @endif

            <button type="submit" class="px-10 py-4 bg-[#1a3a3a] hover:bg-black text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-[#1a3a3a]/20 transition-all active:scale-95">
                {{ __('Sauvegarder les changements') }}
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
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>