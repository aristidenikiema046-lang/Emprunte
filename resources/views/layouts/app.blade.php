<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Emprunte') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-200" style="background-color: #020617;">
        <div class="flex h-screen overflow-hidden bg-slate-950">
            
            <nav class="w-64 bg-gray-900 text-white flex flex-col border-r border-gray-800">
                <div class="p-6 text-2xl font-bold border-b border-gray-800 flex items-center gap-3">
                    <span class="bg-blue-600 p-2 rounded-lg text-xs italic">YA</span> Emprunte
                </div>
                
                <div class="flex-1 overflow-y-auto py-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('dashboard') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-chart-pie mr-3 opacity-50"></i> Dashboard
                    </a>

                    <a href="{{ route('attendances.index') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('attendances.*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-clock mr-3 opacity-50"></i> Présences
                    </a>

                    <a href="{{ route('tasks.index') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('tasks.*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-list-check mr-3 opacity-50"></i> Tâches
                    </a>

                    <a href="{{ route('leaves.index') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('leaves.*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-calendar-day mr-3 opacity-50"></i> Congés
                    </a>

                    <a href="{{ route('payroll.index') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('payroll.*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-file-invoice-dollar mr-3 opacity-50"></i> Paie
                    </a>

                    <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Administration</div>
                    
                    <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('users.*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-users mr-3 opacity-50"></i> Utilisateurs
                    </a>

                    <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Outils</div>
                    
                    <a href="{{ url('/messages') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->is('messages*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-envelope mr-3 opacity-50"></i> Messages
                    </a>

                    <a href="{{ url('/documents') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->is('documents*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-folder-open mr-3 opacity-50"></i> Documents
                    </a>

                    <a href="{{ url('/polls') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->is('polls*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-square-poll-vertical mr-3 opacity-50"></i> Sondages
                    </a>

                    <a href="{{ url('/evaluations') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->is('evaluations*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-star mr-3 opacity-50"></i> Évaluations
                    </a>
                </div>
            </nav>

            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-8 z-40">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle text-[8px] text-emerald-500 animate-pulse"></i>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-tighter">SYSTÈME CONNECTÉ</span>
                    </div>

                    <div class="flex items-center gap-6" x-data="{ open: false }">
                        <div class="relative">
                            <button @click="open = !open" class="focus:outline-none flex items-center gap-3">
                                <div class="text-right hidden md:block border-r border-gray-800 pr-4">
                                    <p class="text-xs font-black text-white leading-none uppercase">{{ Auth::user()->name }}</p>
                                    <p class="text-[9px] text-blue-500 font-bold uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                                </div>
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff' }}" 
                                     class="w-10 h-10 rounded-xl border-2 border-gray-800 hover:border-blue-500 transition-all shadow-lg">
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-3 w-56 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl py-2 z-50">
                                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                                    <i class="fa-solid fa-id-badge text-blue-500"></i> Mon Profil
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                                    <i class="fa-solid fa-user-gear text-blue-500"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-800 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-400 hover:bg-red-500/10 transition-all text-left">
                                        <i class="fa-solid fa-power-off"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-4 md:p-10" style="background-color: #020617;">
                    {{ $slot }}
                </main>
            </div>
        </div>

        {{-- SEUL COMPOSANT UTILISÉ --}}
        @if(session('success') || session('error'))
            <x-notification />
        @endif
    </body>
</html>