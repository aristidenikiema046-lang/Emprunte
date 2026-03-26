<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ManageX | Pilotage d'Entreprise</title>
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

        <section id="features" class="py-32 px-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-10 bg-slate-900/40 border border-slate-800 rounded-[3rem] hover:border-indigo-500/50 transition-all group relative overflow-hidden">
                    <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clock-rotate-left text-indigo-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-4 uppercase italic">Pointage Temps Réel</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Suivez les arrivées et départs de vos collaborateurs d'un simple clic. Statuts en direct pour l'administrateur.</p>
                </div>

                <div class="p-10 bg-slate-900/40 border border-slate-800 rounded-[3rem] hover:border-blue-500/50 transition-all group relative overflow-hidden">
                    <div class="w-14 h-14 bg-blue-600/10 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-list-check text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-4 uppercase italic">Gestion de Missions</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Assignez des tâches, suivez la progression en pourcentage et gérez les priorités de manière dynamique.</p>
                </div>

                <div class="p-10 bg-slate-900/40 border border-slate-800 rounded-[3rem] hover:border-emerald-500/50 transition-all group relative overflow-hidden">
                    <div class="w-14 h-14 bg-emerald-600/10 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-comments text-emerald-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-4 uppercase italic">Communication</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">Discutez en direct avec vos équipes, partagez des fichiers et modifiez vos messages instantanément.</p>
                </div>
            </div>
        </section>

        <section class="py-32 bg-slate-900/20 rounded-[4rem] mx-4 border border-slate-800/50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="text-4xl font-black text-white italic uppercase tracking-tighter leading-none">Déploiement en <span class="text-indigo-500">3 étapes</span></h2>
                    <div class="h-1.5 w-20 bg-indigo-600 mx-auto mt-6 rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-slate-800 border-2 border-slate-700 rounded-3xl flex items-center justify-center text-white text-xl font-black mx-auto mb-8 group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all rotate-3 group-hover:rotate-0 shadow-2xl italic">01</div>
                        <h4 class="text-white font-black uppercase text-sm tracking-widest mb-4">Inscription</h4>
                        <p class="text-slate-500 text-xs font-bold leading-loose uppercase tracking-tighter">Soumettez votre demande d'accès via notre formulaire sécurisé.</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-slate-800 border-2 border-slate-700 rounded-3xl flex items-center justify-center text-white text-xl font-black mx-auto mb-8 group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all -rotate-3 group-hover:rotate-0 shadow-2xl italic">02</div>
                        <h4 class="text-white font-black uppercase text-sm tracking-widest mb-4">Configuration</h4>
                        <p class="text-slate-500 text-xs font-bold leading-loose uppercase tracking-tighter">Nos administrateurs valident et configurent votre instance privée.</p>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-slate-800 border-2 border-slate-700 rounded-3xl flex items-center justify-center text-white text-xl font-black mx-auto mb-8 group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all rotate-6 group-hover:rotate-0 shadow-2xl italic">03</div>
                        <h4 class="text-white font-black uppercase text-sm tracking-widest mb-4">Pilotage</h4>
                        <p class="text-slate-500 text-xs font-bold leading-loose uppercase tracking-tighter">Accédez à votre tableau de bord et commencez la gestion RH.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="pt-32 pb-12 border-t border-slate-800/50 mt-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-16 mb-24">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-xl shadow-indigo-500/20">
                        <span class="text-white font-black text-lg italic">E</span>
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-white uppercase italic">Emprunt<span class="text-indigo-500">E</span></span>
                </div>
                <p class="text-slate-500 text-sm max-w-sm leading-relaxed font-medium">
                    La plateforme de pilotage nouvelle génération pour les entreprises qui exigent performance, transparence et rapidité.
                </p>
            </div>
            <div>
                <h4 class="text-white font-black mb-8 text-[10px] uppercase tracking-[0.3em]">Navigation</h4>
                <ul class="space-y-4 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Plateforme</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Sécurité</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Documentation</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-black mb-8 text-[10px] uppercase tracking-[0.3em]">Support</h4>
                <ul class="space-y-4 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Contact</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Légal</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Statut API</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 pt-12 border-t border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} Emprunte System. Engineered for Speed.
            </p>
            <div class="flex gap-8">
                <a href="#" class="text-slate-500 hover:text-white transition-all scale-125"><i class="fa-brands fa-linkedin"></i></a>
                <a href="#" class="text-slate-500 hover:text-white transition-all scale-125"><i class="fa-brands fa-github"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>