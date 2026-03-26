<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ManageX | Pilotage d'Entreprise</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-[#0f172a] text-slate-200 selection:bg-indigo-500 selection:text-white font-sans">
    
    <nav class="fixed w-full z-50 backdrop-blur-lg border-b border-slate-800 bg-[#0f172a]/80">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <span class="text-white font-black text-xl italic">E</span>
                </div>
                <span class="text-xl font-black tracking-tighter text-white uppercase italic">Emprunt<span class="text-indigo-500">E</span></span>
            </div>

            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-xs font-black uppercase tracking-widest hover:text-indigo-400 transition">Tableau de Bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest hover:text-indigo-400 transition">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-xl shadow-indigo-500/20">
                                Demande d'accès
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="relative pt-48 pb-32 overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 text-center">
                @if(session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" 
                     class="max-w-md mx-auto mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm font-bold flex items-center justify-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
                @endif

                <div class="inline-block px-4 py-1.5 mb-8 rounded-full border border-indigo-500/30 bg-indigo-500/5 text-indigo-400 text-[10px] font-black uppercase tracking-[0.3em]">
                    Solution RH & Gestion de Tâches
                </div>
                <h1 class="text-5xl md:text-8xl font-black text-white leading-[0.9] mb-10 tracking-tighter italic">
                    Gérez votre équipe <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-500 uppercase">sans effort.</span>
                </h1>
                <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-14 leading-relaxed font-medium">
                    Emprunte centralise vos présences, vos tâches et votre paie dans une interface ultra-rapide conçue pour la performance.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 bg-white text-slate-950 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-slate-200 transition-all shadow-2xl">
                        Se connecter
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 bg-slate-800/50 text-white rounded-2xl font-black uppercase text-xs tracking-widest border border-slate-700 hover:bg-slate-700 transition-all">
                        Demander un accès
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <section class="py-12 px-6 max-w-7xl mx-auto border-y border-slate-800/50 bg-slate-900/10 rounded-[3rem]">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-black text-white italic">+98%</div>
                    <div class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em] mt-2 ml-1">Satisfaction Client</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-indigo-500 italic">2.4ms</div>
                    <div class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em] mt-2 ml-1">Latence Serveur</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-white italic">24/7</div>
                    <div class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em] mt-2 ml-1">Disponibilité</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-blue-500 italic">PWA</div>
                    <div class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em] mt-2 ml-1">Optimisé Mobile</div>
                </div>
            </div>
        </section>
    </main>

    <footer class="pt-32 pb-12 border-t border-slate-800/50 mt-20">
        <div class="max-w-7xl mx-auto px-6 pt-12 border-t border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} Emprunte System. Engineered for Speed.
            </p>
            <div class="flex items-center gap-3">
                 <div class="flex items-center gap-2 opacity-50">
                    <div class="w-6 h-6 bg-indigo-600 rounded flex items-center justify-center">
                        <span class="text-white font-black text-[10px] italic">E</span>
                    </div>
                    <span class="text-xs font-black tracking-tighter text-white uppercase italic">EmpruntE</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>