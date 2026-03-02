<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Emprunte') }}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-200">
        <div class="flex h-screen overflow-hidden">
            
            {{-- Sidebar --}}
            <nav class="w-64 bg-gray-900 text-white flex flex-col border-r border-gray-800">
                <div class="p-6 text-2xl font-bold border-b border-gray-800 flex items-center gap-3">
                    <span class="bg-blue-600 p-2 rounded-lg text-xs italic">YA</span>
                    Emprunte
                </div>
                
                <div class="flex-1 overflow-y-auto py-4">
                    <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa-solid fa-chart-pie mr-3 opacity-50"></i> Dashboard
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('attendances.index')" :active="request()->routeIs('attendances.index')">
                        <i class="fa-solid fa-clock mr-3 opacity-50"></i> Présences
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                        <i class="fa-solid fa-list-check mr-3 opacity-50"></i> Tâches
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('leaves.index')" :active="request()->routeIs('leaves.index')">
                        <i class="fa-solid fa-calendar-day mr-3 opacity-50"></i> Congés
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('payroll.index')" :active="request()->routeIs('payroll.index')"> 
                        <i class="fa-solid fa-file-invoice-dollar mr-3 opacity-50"></i> Paie 
                    </x-nav-link-sidebar>
                    
                    {{-- Accès Admin --}}
                    @if(Auth::user()->role === 'admin')
                        <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Administration</div>
                        <x-nav-link-sidebar :href="route('users.index')" :active="request()->routeIs('users.index')">
                            <i class="fa-solid fa-users mr-3 opacity-50"></i> Utilisateurs
                        </x-nav-link-sidebar>
                    @endif
                    
                    <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Outils</div>
                    <x-nav-link-sidebar :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        <i class="fa-solid fa-envelope mr-3 opacity-50"></i> Messages
                    </x-nav-link-sidebar>

                    {{-- Dropdown Documents --}}
                    <div x-data="{ open: {{ request()->routeIs('documents.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-all focus:outline-none">
                            <span class="text-sm font-semibold flex items-center gap-3">
                                <i class="fa-solid fa-folder-open opacity-50"></i> Documents
                            </span>
                            <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-cloak class="bg-gray-800/30 pb-2">
                            <x-nav-link-sidebar :href="route('documents.received')" :active="request()->routeIs('documents.received')">
                                <span class="text-xs ml-8 italic">Docs reçus</span>
                            </x-nav-link-sidebar>
                            <x-nav-link-sidebar :href="route('documents.sent')" :active="request()->routeIs('documents.sent')">
                                <span class="text-xs ml-8 italic">Docs envoyés</span>
                            </x-nav-link-sidebar>
                            <x-nav-link-sidebar :href="route('documents.create')" :active="request()->routeIs('documents.create')">
                                <span class="text-xs ml-8 italic">Envoyer un doc</span>
                            </x-nav-link-sidebar>
                        </div>
                    </div>

                    <x-nav-link-sidebar :href="route('polls.index')" :active="request()->routeIs('polls.*')">
                        <i class="fa-solid fa-square-poll-vertical mr-3 opacity-50"></i> Sondages
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('evaluations.index')" :active="request()->routeIs('evaluations.*')">
                        <i class="fa-solid fa-star-half-stroke mr-3 opacity-50"></i> Évaluations
                    </x-nav-link-sidebar>
                </div>
            </nav>

            {{-- Main Wrapper (Header + Content) --}}
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                
                {{-- Top Header --}}
                <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-8 z-40">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle text-[8px] text-emerald-500 animate-pulse"></i>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-tighter">Système Connecté</span>
                    </div>

                    {{-- Profil à Droite --}}
                    <div class="flex items-center gap-6" x-data="{ open: false }">
                        <div class="text-right hidden md:block border-r border-gray-800 pr-4">
                            <p class="text-xs font-black text-white leading-none uppercase">{{ Auth::user()->name }}</p>
                            <p class="text-[9px] text-blue-500 font-bold uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                        </div>

                        <div class="relative">
                            <button @click="open = !open" class="focus:outline-none flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff" 
                                     class="w-10 h-10 rounded-xl border-2 border-gray-800 hover:border-blue-500 transition-all shadow-lg">
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-3 w-56 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl py-2 overflow-hidden">
                                
                                <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                                    <i class="fa-solid fa-id-badge text-blue-500"></i> Mon Profil
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                                    <i class="fa-solid fa-user-gear text-blue-500"></i> Paramètres
                                </a>

                                <div class="border-t border-gray-800 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-400 hover:bg-red-500/10 transition-all">
                                        <i class="fa-solid fa-power-off"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Contenu Variable --}}
                <main class="flex-1 overflow-y-auto p-4 md:p-10 bg-slate-950">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>
</html>