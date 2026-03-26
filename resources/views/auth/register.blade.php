<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demander un accès - Emprunte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f172a; }
        .auth-container {
            background-color: #1e293b;
            padding: 2.5rem;
            border-radius: 2.5rem;
            border: 1px solid #334155;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .btn-emprunte {
            background-color: #4f46e5 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white !important;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 1rem;
            border-radius: 1rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.7rem;
            border: none;
            cursor: pointer;
        }
        .btn-emprunte:hover {
            background-color: #6366f1 !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }
        .input-emprunte {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: white !important;
            transition: all 0.2s ease;
            width: 100%;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
        }
        .input-emprunte:focus {
            border-color: #4f46e5 !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.4);
        }
        .label-style {
            display: block;
            font-weight: 900;
            font-size: 0.65rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 0.5rem;
            margin-left: 0.25rem;
        }
    </style>
</head>
<body class="antialiased font-sans flex items-center justify-center min-h-screen p-4">

    <div class="auth-container w-full max-w-md">
        <div class="mb-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl mb-4 shadow-xl shadow-indigo-500/20">
                <span class="text-white text-3xl font-black italic">E</span>
            </div>
            <h2 class="text-2xl font-black text-white tracking-tighter uppercase italic">Demander un accès</h2>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.2em] mt-2">
                Rejoignez l'écosystème <span class="text-indigo-500">Emprunte</span>
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Nom --}}
            <div>
                <label for="name" class="label-style">Nom complet</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" 
                    class="input-emprunte" placeholder="Ex: Jean Marcory" required autofocus />
                @if($errors->has('name'))
                    <p class="text-red-400 text-[10px] font-bold uppercase mt-2 ml-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="label-style">Email Professionnel</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                    class="input-emprunte" placeholder="nom@entreprise.com" required />
                @if($errors->has('email'))
                    <p class="text-red-400 text-[10px] font-bold uppercase mt-2 ml-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            {{-- Passwords --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="label-style">Mot de passe</label>
                    <input id="password" type="password" name="password" class="input-emprunte" placeholder="••••••••" required />
                </div>
                <div>
                    <label for="password_confirmation" class="label-style">Confirmation</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="input-emprunte" placeholder="••••••••" required />
                </div>
            </div>
            @if($errors->has('password'))
                <p class="text-red-400 text-[10px] font-bold uppercase mt-1 ml-1">{{ $errors->first('password') }}</p>
            @endif

            <div class="flex flex-col items-center justify-end mt-10 space-y-6">
                <button type="submit" class="btn-emprunte shadow-lg shadow-indigo-500/20">
                    Envoyer ma demande
                </button>

                <div class="pt-6 border-t border-slate-700/50 w-full text-center">
                    <a class="text-[10px] font-bold text-slate-500 hover:text-indigo-400 uppercase tracking-widest transition-colors" href="{{ route('login') }}">
                        Déjà inscrit ? <span class="text-indigo-500 font-black underline ml-1">Se connecter</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>