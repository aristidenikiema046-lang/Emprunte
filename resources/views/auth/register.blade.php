<x-guest-layout>
    <style>
        /* Personnalisation pour le site Emprunte */
        .auth-card-body {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
        }
        .btn-emprunte {
            background-color: #4f46e5 !important; /* Bleu Indigo Tech */
            transition: all 0.3s ease;
            color: white !important;
        }
        .btn-emprunte:hover {
            background-color: #4338ca !important; /* Bleu plus sombre au survol */
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .text-emprunte { color: #4f46e5; }
        
        /* Focus des champs en bleu indigo */
        .input-emprunte:focus {
            border-color: #4f46e5 !important;
            --tw-ring-color: #4f46e5 !important;
        }
    </style>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Créer un compte</h2>
        <p class="text-sm text-gray-600">Rejoignez l'aventure <span class="text-emprunte font-bold">Emprunte</span></p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="font-semibold text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Adresse Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="font-semibold text-gray-700" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-6 space-y-4">
            <x-primary-button class="w-full justify-center py-3 btn-emprunte uppercase tracking-widest text-xs font-bold">
                {{ __('S\'inscrire') }}
            </x-primary-button>

            <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Déjà inscrit ? Connectez-vous') }}
            </a>
        </div>
    </form>
</x-guest-layout>