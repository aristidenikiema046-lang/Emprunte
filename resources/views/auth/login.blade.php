<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Emprunte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
        /* Couleurs personnalisées pour correspondre à la Landing Page */
        .bg-main { background-color: #0f172a; }
        .bg-card { background-color: #1e293b; }
        
        .btn-emprunte {
            background-color: #4f46e5 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white !important;
        }
        .btn-emprunte:hover {
            background-color: #6366f1 !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }

        .btn-retour {
            background-color: #334155;
            transition: all 0.3s ease;
        }
        .btn-retour:hover {
            background-color: #475569;
            transform: translateX(-4px);
        }

        .input-emprunte {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: white !important;
        }
        .input-emprunte:focus {
            border-color: #4f46e5 !important;
            ring: 2px;
            ring-color: #4f46e5;
        }
    </style>
</head>
<body class="bg-main font-sans antialiased text-slate-200">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        
        {{-- Conteneur de la Carte --}}
        <div class="w-full sm:max-w-md px-8 py-10 bg-card shadow-2xl overflow-hidden rounded-[2.5rem] border border-slate-800">
            
            {{-- Bouton de redirection vers l'accueil --}}
            <div class="mb-10">
                <a href="{{ url('/') }}" class="btn-retour inline-flex items-center px-5 py-2.5 rounded-xl text-white text-[10px] font-black uppercase tracking-widest shadow-lg">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>

            {{-- Header de connexion --}}
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl mb-4 shadow-xl shadow-indigo-500/20">
                    <span class="text-white text-3xl font-black italic">E</span>
                </div>
                <h2 class="text-3xl font-black text-white tracking-tighter uppercase italic">Connexion</h2>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em] mt-2">
                    Espace Membre <span class="text-indigo-500 font-black">Emprunte</span>
                </p>
            </div>

            {{-- Status Session --}}
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-xs font-bold flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Champ Email --}}
                <div>
                    <label for="email" class="block font-black text-[10px] text-slate-500 uppercase tracking-widest mb-2 ml-1">Identifiant Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" 
                            class="block w-full pl-11 pr-4 py-4 rounded-2xl shadow-sm input-emprunte border text-sm transition-all" 
                            placeholder="votre@email.com" required autofocus />
                    </div>
                    @error('email')
                        <p class="text-[10px] text-red-500 font-black uppercase mt-2 ml-1 tracking-tighter">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Champ Mot de passe --}}
                <div>
                    <label for="password" class="block font-black text-[10px] text-slate-500 uppercase tracking-widest mb-2 ml-1">Mot de passe</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input id="password" type="password" name="password" 
                            class="block w-full pl-11 pr-4 py-4 rounded-2xl shadow-sm input-emprunte border text-sm transition-all" 
                            placeholder="••••••••••••" required />
                    </div>
                    @error('password')
                        <p class="text-[10px] text-red-500 font-black uppercase mt-2 ml-1 tracking-tighter">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Options --}}
                <div class="flex items-center justify-between px-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-700 text-indigo-600 bg-slate-900 focus:ring-indigo-500 w-4 h-4" name="remember">
                        <span class="ms-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition">Rester connecté</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-[10px] font-black text-indigo-500 hover:text-indigo-400 uppercase tracking-widest transition" href="{{ route('password.request') }}">
                            Perdu ?
                        </a>
                    @endif
                </div>

                {{-- Bouton Submit --}}
                <div class="pt-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-4 btn-emprunte rounded-2xl font-black text-xs text-white uppercase tracking-[0.3em] shadow-xl">
                        S'identifier
                        <i class="fa-solid fa-arrow-right-to-bracket ml-3"></i>
                    </button>
                </div>

                {{-- Footer Link --}}
                <div class="text-center pt-8 border-t border-slate-800/50 mt-4">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                        Nouveau collaborateur ? 
                        <a href="{{ route('register') }}" class="text-indigo-500 font-black hover:underline ml-1">Demander un accès</a>
                    </p>
                </div>
            </form>
        </div>

        {{-- Petit texte de copyright sous la carte --}}
        <p class="mt-8 text-[10px] font-bold text-slate-600 uppercase tracking-[0.3em]">
            &copy; {{ date('Y') }} Emprunte System
        </p>
    </div>
</body>
</html>