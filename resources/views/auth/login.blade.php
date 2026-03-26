<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Emprunte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
        /* Style pour le bouton de retour plein */
        .btn-retour {
            background-color: #334155; /* Slate 700 */
            transition: all 0.3s ease;
        }
        .btn-retour:hover {
            background-color: #1e293b; /* Slate 800 */
            transform: translateX(-3px);
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
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
            
            {{-- Bouton de redirection plein en haut --}}
            <div class="mb-8">
                <a href="{{ url('/accueil') }}" class="btn-retour inline-flex items-center px-4 py-2 rounded-xl text-white text-[10px] font-black uppercase tracking-widest shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>

            <div class="mb-8 text-center">
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase italic">Connexion</h2>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">
                    Accédez à votre espace <span class="text-emprunte">Emprunte</span>
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-black text-[10px] text-gray-400 uppercase tracking-widest mb-2">Identifiant Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                        class="block w-full bg-gray-50 border-gray-200 rounded-xl shadow-sm input-emprunte p-3 border text-sm" 
                        placeholder="nom@exemple.com" required autofocus />
                    @error('email')
                        <p class="text-[10px] text-red-600 font-black uppercase mt-2 tracking-tighter">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-black text-[10px] text-gray-400 uppercase tracking-widest mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" 
                        class="block w-full bg-gray-50 border-gray-200 rounded-xl shadow-sm input-emprunte p-3 border text-sm" 
                        placeholder="••••••••" required />
                    @error('password')
                        <p class="text-[10px] text-red-600 font-black uppercase mt-2 tracking-tighter">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-4 h-4" name="remember">
                        <span class="ms-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Rester connecté</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-[10px] font-black text-gray-400 hover:text-indigo-600 uppercase tracking-widest transition" href="{{ route('password.request') }}">
                            Oubli ?
                        </a>
                    @endif
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-4 btn-emprunte rounded-xl font-black text-xs text-white uppercase tracking-[0.2em] shadow-lg shadow-indigo-200">
                        S'identifier
                    </button>
                </div>

                <div class="text-center pt-6 border-t border-gray-50">
                    <a class="text-[10px] font-bold text-gray-400 hover:text-indigo-600 uppercase tracking-widest transition" href="{{ route('register') }}">
                        Nouveau ici ? <span class="text-emprunte font-black underline">Créer un compte</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>