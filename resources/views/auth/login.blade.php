<x-guest-layout>
    <style>
        /* Cohérence avec le style Emprunte */
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

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Connexion</h2>
        <p class="text-sm text-gray-600">Heureux de vous revoir sur <span class="text-emprunte font-bold">Emprunte</span></p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Adresse Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 input-emprunte rounded-lg shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-end mt-6 space-y-4">
            <x-primary-button class="w-full justify-center py-3 btn-emprunte uppercase tracking-widest text-xs font-bold">
                {{ __('Se connecter') }}
            </x-primary-button>

            <div class="flex flex-col items-center space-y-2">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif

                <a class="text-sm text-gray-600 hover:text-indigo-600 font-medium" href="{{ route('register') }}">
                    Pas encore de compte ? <span class="text-emprunte fw-bold">Créer un compte</span>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>