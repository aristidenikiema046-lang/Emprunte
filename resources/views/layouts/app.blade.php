<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ManageX') }}</title>

        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='25' fill='%234f46e5'/><text x='50%' y='54%' dominant-baseline='central' text-anchor='middle' fill='white' font-family='sans-serif' font-weight='900' font-style='italic' font-size='65'>E</text></svg>">
        <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='25' fill='%234f46e5'/><text x='50%' y='54%' dominant-baseline='central' text-anchor='middle' fill='white' font-family='sans-serif' font-weight='900' font-style='italic' font-size='65'>E</text></svg>">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased text-slate-200" style="background-color: #020617;">
        <div class="flex h-screen overflow-hidden bg-slate-950">
            
            <nav class="w-64 bg-gray-900 text-white flex flex-col border-r border-gray-800 shrink-0">
                <div class="p-6 border-b border-gray-800 flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <span class="text-white font-black text-sm italic">E</span>
                    </div>
                    <span class="text-lg font-black tracking-tighter text-white uppercase italic">Emprunt<span class="text-indigo-500">E</span></span>
                </div>
                
                <div class="flex-1 overflow-y-auto py-4 space-y-1 custom-scrollbar">
                    
                    <div class="px-6 py-2 text-[10px] font-black text-slate-500 uppercase tracking-widest">Pilotage</div>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('dashboard') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-chart-pie mr-3 w-4 opacity-50"></i> Tableau de bord
                    </a>

                    <a href="{{ route('attendances.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('attendances.*') || request()->routeIs('admin.attendances.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-clock mr-3 w-4 opacity-50"></i> Présences
                    </a>

                    <a href="{{ route('tasks.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('tasks.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-list-check mr-3 w-4 opacity-50"></i> Missions
                    </a>

                    <div class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Ressources Humaines</div>

                    <a href="{{ route('leaves.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('leaves.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-calendar-day mr-3 w-4 opacity-50"></i> Congés
                    </a>

                    <a href="{{ route('payroll.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('payroll.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-file-invoice-dollar mr-3 w-4 opacity-50"></i> Paie & Salaires
                    </a>

                    <a href="{{ route('evaluations.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('evaluations.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-star mr-3 w-4 opacity-50"></i> Évaluations
                    </a>

                    <div class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Collaboration</div>

                    <a href="{{ route('messages.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('messages.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-comment-dots mr-3 w-4 opacity-50"></i> Messages
                    </a>

                    <a href="{{ route('documents.received') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('documents.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-folder-open mr-3 w-4 opacity-50"></i> Documents
                    </a>

                    <a href="{{ route('polls.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('polls.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-square-poll-vertical mr-3 w-4 opacity-50"></i> Sondages
                    </a>

                    @can('admin-only')
                        <div class="px-6 py-4 mt-2 border-t border-gray-800/50 text-[10px] font-black text-indigo-400 uppercase tracking-widest">Administration</div>
                        
                        <a href="{{ route('users.index') }}" class="flex items-center px-6 py-2.5 text-xs font-bold {{ request()->routeIs('users.*') ? 'text-white bg-indigo-600/20 border-r-4 border-indigo-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                            <i class="fa-solid fa-users-gear mr-3 w-4 opacity-50"></i> Gestion Staff
                        </a>
                    @endcan

                </div>

                <div class="p-4 border-t border-gray-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 text-xs font-bold text-rose-400 hover:bg-rose-500/10 rounded-lg transition">
                            <i class="fa-solid fa-power-off mr-3"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </nav>

            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                
                <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-8 z-40">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle text-[8px] text-emerald-500 animate-pulse"></i>
                        <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest">Système Opérationnel</span>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-4">
                            <div class="text-right hidden md:block">
                                <p class="text-xs font-black text-white uppercase leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] font-bold text-indigo-500 uppercase tracking-tighter mt-1">
                                    {{ Auth::user()->can('admin-only') ? 'Administrateur' : 'Collaborateur' }}
                                </p>
                            </div>
                            <a href="{{ route('profile.show') }}">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff" 
                                     class="w-10 h-10 rounded-xl border-2 border-gray-800 shadow-lg hover:border-indigo-500 transition-all">
                            </a>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto bg-[#020617] p-4 md:p-8 custom-scrollbar">
                    {{ $slot }}
                </main>

            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #334155; }
        </style>
    </body>
</html>