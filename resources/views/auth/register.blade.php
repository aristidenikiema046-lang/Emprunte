<x-guest-layout>
    <style>
        .auth-container {
            background-color: white !important;
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .btn-emprunte {
            background-color: #4f46e5 !important;
            transition: all 0.3s ease;
            color: white !important;
        }
        .btn-emprunte:hover {
            background-color: #4338ca !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .text-emprunte { color: #4f46e5; }
        .input-emprunte:focus {
            border-color: #4f46e5 !important;
            --tw-ring-color: #4f46e5 !important;
        }
    </style>

    <div class="auth-container">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Demander un accès</h2>
            <p class="text-sm text-gray-600">Rejoignez l'espace collaboratif <span class="text-emprunte font-bold">Emprunte</span></p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nom --}}
            <div>
                <x-input-label for="name" :value="__('Nom complet')" class="font-semibold text-gray-700" />
                <x-text-input id="name" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <x-input-label for="email" :value="__('Adresse Email')" class="font-semibold text-gray-700" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" class="font-semibold text-gray-700" />
                <x-text-input id="password" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirmation --}}
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="font-semibold text-gray-700" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="password" name="password_confirmation" required />
            </div>

            <div class="flex flex-col items-center justify-end mt-8 space-y-4">
                <x-primary-button class="w-full justify-center py-3 btn-emprunte uppercase tracking-widest text-xs font-bold">
                    {{ __('Envoyer la demande d\'accès') }}
                </x-primary-button>

                <a class="underline text-sm text-gray-600 hover:text-indigo-600" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ? Connectez-vous') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>