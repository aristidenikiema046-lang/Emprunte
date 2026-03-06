<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Emprunte</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            outline: none;
            ring: 2px;
            ring-color: #4f46e5;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Connexion</h2>
                <p class="text-sm text-gray-600">Heureux de vous revoir sur <span class="text-emprunte font-bold">Emprunte</span></p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block font-semibold text-sm text-gray-700">Adresse Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm input-emprunte p-2 border" 
                        required autofocus autocomplete="username" />
                    @if ($errors->get('email'))
                        <ul class="text-sm text-red-600 space-y-1 mt-2">
                            @foreach ((array) $errors->get('email') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-semibold text-sm text-gray-700">Mot de passe</label>
                    <input id="password" type="password" name="password" 
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm input-emprunte p-2 border" 
                        required autocomplete="current-password" />
                    @if ($errors->get('password'))
                        <ul class="text-sm text-red-600 space-y-1 mt-2">
                            @foreach ((array) $errors->get('password') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                </div>

                <div class="flex flex-col items-center justify-end mt-6 space-y-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 btn-emprunte border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Se connecter
                    </button>

                    <div class="flex flex-col items-center space-y-2">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif

                        <a class="text-sm text-gray-600 hover:text-indigo-600 font-medium" href="{{ route('register') }}">
                            Pas encore de compte ? <span class="text-emprunte font-bold">Créer un compte</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>