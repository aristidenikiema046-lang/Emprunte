<section class="bg-[#1a2234] rounded-[2.5rem] p-8 shadow-2xl border border-white/5 max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-10">
        <h2 class="text-xl font-bold text-white tracking-tight">Informations Personnelles</h2>
        <button type="button" class="text-teal-400 text-sm font-bold flex items-center gap-2 hover:text-teal-300 transition-colors">
            <i class="fa-solid fa-pen-to-square text-xs"></i> Modifier
        </button>
    </div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        {{-- Avatar Style "Badge" --}}
        <div class="flex items-center gap-5 mb-10 p-4 bg-white/5 rounded-3xl border border-white/5">
            <div class="relative w-20 h-20">
                <img id="preview" 
                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=2dd4bf&color=1a2234' }}" 
                     class="w-full h-full rounded-2xl object-cover shadow-lg border-2 border-teal-500/20">
                <label for="avatar" class="absolute -bottom-2 -right-2 bg-teal-500 text-[#1a2234] p-2 rounded-xl shadow-lg cursor-pointer hover:bg-teal-400 transition-transform active:scale-90">
                    <i class="fa-solid fa-camera text-xs"></i>
                </label>
                <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
            </div>
            <div>
                <p class="text-lg font-bold text-white">{{ $user->name }}</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></span>
                    <p class="text-xs text-teal-400 font-black uppercase tracking-widest">Collaborateur Actif</p>
                </div>
            </div>
        </div>

        {{-- Liste des champs avec Labels Vert Menthe --}}
        <div class="space-y-8 px-2">
            
            {{-- Nom Complet --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Nom complet</label>
                <input name="name" type="text" value="{{ old('name', $user->name) }}" 
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent placeholder-white/20" required>
            </div>

            {{-- Email --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Email professionnel</label>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" 
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent" required>
            </div>

            {{-- Téléphone --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Téléphone</label>
                <input name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="-"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent">
            </div>

            {{-- Genre --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Genre</label>
                <select name="gender" class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent appearance-none cursor-pointer">
                    <option value="Homme" class="bg-[#1a2234]" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" class="bg-[#1a2234]" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            {{-- Adresse --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Adresse de résidence</label>
                <input name="address" type="text" value="{{ old('address', $user->address) }}" placeholder="Non renseignée"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent">
            </div>

            {{-- Situation Familiale --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Situation Familiale</label>
                <input name="family_status" type="text" value="{{ old('family_status', $user->family_status) }}" placeholder="Célibataire"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent">
            </div>

            {{-- Numéro CNPS --}}
            <div class="border-b border-white/10 pb-4 group">
                <label class="block text-xs font-black text-teal-400 uppercase tracking-widest mb-1 group-focus-within:text-white transition-colors">Numéro CNPS</label>
                <input name="cnps_number" type="text" value="{{ old('cnps_number', $user->cnps_number) }}" placeholder="--- --- ---"
                       class="w-full p-0 border-none focus:ring-0 text-base font-black text-teal-300 bg-transparent tracking-widest">
            </div>
        </div>

        {{-- Footer Action --}}
        <div class="pt-10">
            <button type="submit" class="w-full py-5 bg-teal-500 hover:bg-teal-400 text-[#1a2234] rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-xl shadow-teal-900/40 transition-all active:scale-[0.98]">
                Enregistrer les modifications
            </button>
            
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="flex items-center justify-center gap-2 mt-6 text-teal-400 font-bold text-xs bg-teal-500/10 py-2 rounded-full border border-teal-500/20">
                    <i class="fa-solid fa-check-double"></i>
                    Synchronisation réussie
                </div>
            @endif
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