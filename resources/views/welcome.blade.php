<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ManageX | Pilotage d'Entreprise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body class="antialiased bg-[#0f172a] text-slate-200 selection:bg-indigo-500 selection:text-white">
    
    <nav class="fixed w-full z-50 backdrop-blur-lg border-b border-slate-800 bg-[#0f172a]/80">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <span class="text-white font-black text-xl">E</span>
                </div>
                <span class="text-xl font-black tracking-tighter text-white uppercase">Emprunt<span class="text-indigo-500">E</span></span>
            </div>

            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold hover:text-indigo-400 transition">Tableau de Bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold hover:text-indigo-400 transition">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-indigo-500/20">
                                Inscription
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="relative pt-40 pb-20 overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-block px-4 py-1.5 mb-6 rounded-full border border-indigo-500/30 bg-indigo-500/5 text-indigo-400 text-xs font-black uppercase tracking-widest">
                    Solution RH & Gestion de Tâches
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                    Gérez votre équipe <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-500">sans effort.</span>
                </h1>
                <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                    Emprunte centralise vos présences, vos tâches, vos sondages et votre paie dans une interface ultra-rapide et intuitive.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-950 rounded-2xl font-black uppercase text-sm hover:bg-slate-200 transition-all shadow-xl">
                        Créer un compte
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-slate-800 text-white rounded-2xl font-black uppercase text-sm border border-slate-700 hover:bg-slate-700 transition-all">
                        Voir les fonctionnalités
                    </a>
                </div>
            </div>
        </section>

        <section id="features" class="py-20 px-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-slate-900/50 border border-slate-800 rounded-[2.5rem] hover:border-indigo-500/50 transition-all group">
                    <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clock-rotate-left text-indigo-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Pointage Temps Réel</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Suivez les arrivées et départs de vos collaborateurs d'un simple clic. Statuts en direct pour l'administrateur.</p>
                </div>

                <div class="p-8 bg-slate-900/50 border border-slate-800 rounded-[2.5rem] hover:border-blue-500/50 transition-all group">
                    <div class="w-14 h-14 bg-blue-600/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-list-check text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Gestion de Missions</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Assignez des tâches, suivez la progression en pourcentage et gérez les priorités de manière dynamique.</p>
                </div>

                <div class="p-8 bg-slate-900/50 border border-slate-800 rounded-[2.5rem] hover:border-emerald-500/50 transition-all group">
                    <div class="w-14 h-14 bg-emerald-600/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-comments text-emerald-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Communication Interne</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Discutez en direct avec vos équipes, partagez des fichiers et modifiez vos messages instantanément.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-10 border-t border-slate-800 text-center">
        <p class="text-slate-600 text-sm font-medium">
            &copy; {{ date('Y') }} Emprunte. Tous droits réservés. Designé pour la performance.
        </p>
    </footer>
</body>
</html>