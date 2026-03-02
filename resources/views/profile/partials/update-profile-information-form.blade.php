<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations du Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de votre profil, votre photo et vos contacts d'urgence.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- L'ajout de enctype="multipart/form-data" est OBLIGATOIRE pour la photo --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Section Photo/Avatar --}}
        <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-2xl">
            <div class="relative">
                <img id="preview" 
                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1a3a3a&color=fff' }}" 
                     class="w-24 h-24 rounded-2xl object-cover border-2 border-white shadow-sm">
            </div>
            <div class="flex-1">
                <x-input-label for="avatar" :value="__('Changer la photo de profil')" class="mb-2" />
                <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-700 cursor-pointer" onchange="previewImage(event)"/>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        {{-- Infos de base --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Nom complet')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Téléphone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="gender" :value="__('Genre')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="Homme" {{ old('gender', $user->gender) == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('gender', $user->gender) == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>
        </div>

        {{-- Adresse et Famille --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <x-input-label for="address" :value="__('Adresse Résidentielle')" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
            </div>

            <div>
                <x-input-label for="family_status" :value="__('Situation Familiale')" />
                <x-text-input id="family_status" name="family_status" type="text" class="mt-1 block w-full" :value="old('family_status', $user->family_status)" placeholder="Célibataire (0 enfants)" />
            </div>

            <div>
                <x-input-label for="cnps_number" :value="__('Numéro CNPS')" />
                <x-text-input id="cnps_number" name="cnps_number" type="text" class="mt-1 block w-full" :value="old('cnps_number', $user->cnps_number)" />
            </div>
        </div>

        {{-- Contact d'urgence --}}
        <div class="p-4 bg-blue-50/50 rounded-2xl space-y-4">
            <h3 class="text-sm font-bold text-blue-900 uppercase tracking-widest">Contact d'Urgence</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="emergency_contact_name" :value="__('Nom du contact')" />
                    <x-text-input id="emergency_contact_name" name="emergency_contact_name" type="text" class="mt-1 block w-full" :value="old('emergency_contact_name', $user->emergency_contact_name)" />
                </div>
                <div>
                    <x-input-label for="emergency_contact_phone" :value="__('Téléphone')" />
                    <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" type="text" class="mt-1 block w-full" :value="old('emergency_contact_phone', $user->emergency_contact_phone)" />
                </div>
                <div>
                    <x-input-label for="emergency_contact_relation" :value="__('Lien de parenté')" />
                    <x-text-input id="emergency_contact_relation" name="emergency_contact_relation" type="text" class="mt-1 block w-full" :value="old('emergency_contact_relation', $user->emergency_contact_relation)" placeholder="Ex: Épouse, Père" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer les modifications') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 font-bold">{{ __('Modifications enregistrées avec succès.') }}</p>
            @endif
        </div>
    </form>

    {{-- Petit script pour voir la photo immédiatement --}}
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
</section>