<section class="bg-[#1a2234] rounded-[2.5rem] p-8 shadow-2xl border border-white/5 max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-10">
        <h2 class="text-xl font-bold text-white tracking-tight">Informations Personnelles</h2>
        <button type="button" class="text-blue-400 text-sm font-bold flex items-center gap-2 hover:text-blue-300 transition-colors">
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
                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=3b82f6&color=fff' }}" 
                     class="w-full h-full rounded-2xl object-cover shadow-lg">
                <label for="avatar" class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-2 rounded-xl shadow-lg cursor-pointer hover:bg-blue-500 transition-transform active:scale-90">
                    <i class="fa-solid fa-camera text-xs"></i>
                </label>
                <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)"/>
            </div>
            <div>
                <p class="text-lg font-bold text-white">{{ $user->name }}</p>
                <p class="text-xs text-blue-400 font-black uppercase tracking-widest">Collaborateur</p>
            </div>
        </div>

        {{-- Liste des champs en mode "Bleu Nuit" --}}
        <div class="space-y-8 px-2">
            
            {{-- Nom Complet --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nom complet</label>
                <input name="name" type="text" value="{{ old('name', $user->name) }}" 
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent placeholder-gray-600" required>
            </div>

            {{-- Email --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email professionnel</label>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" 
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent" required>
            </div>

            {{-- Téléphone --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Téléphone</label>
                <input name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="-"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent">
            </div>

            {{-- Genre --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Genre</label>
                <select name="gender" class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent appearance-none cursor-pointer">
                    <option value="Homme" class="bg-[#1a2234]" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" class="bg-[#1a2234]" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            {{-- Adresse --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Adresse de résidence</label>
                <input name="address" type="text" value="{{ old('address', $user->address) }}" placeholder="Non renseignée"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent">
            </div>

            {{-- Situation Familiale --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Situation Familiale</label>
                <input name="family_status" type="text" value="{{ old('family_status', $user->family_status) }}" placeholder="Célibataire"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-gray-100 bg-transparent">
            </div>

            {{-- Numéro CNPS --}}
            <div class="border-b border-white/5 pb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Numéro CNPS</label>
                <input name="cnps_number" type="text" value="{{ old('cnps_number', $user->cnps_number) }}" placeholder="--- --- ---"
                       class="w-full p-0 border-none focus:ring-0 text-base font-bold text-blue-400 bg-transparent">
            </div>
        </div>

        {{-- Footer Action --}}
        <div class="pt-10">
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-blue-900/20 transition-all active:scale-95">
                Mettre à jour le profil
            </button>
            
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="flex items-center justify-center gap-2 mt-4 text-emerald-400 font-bold text-xs">
                    <i class="fa-solid fa-circle-check"></i>
                    Modifications enregistrées
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