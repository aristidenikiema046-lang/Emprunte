<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Emprunte') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-200" style="background-color: #020617;">
        <div class="flex h-screen overflow-hidden bg-slate-950">
            
            <nav class="w-64 bg-gray-900 text-white flex flex-col border-r border-gray-800">
                <div class="p-6 text-2xl font-bold border-b border-gray-800 flex items-center gap-3">
                    <span class="bg-blue-600 p-2 rounded-lg text-xs italic">YA</span> Emprunte
                </div>
                
                <div class="flex-1 overflow-y-auto py-4">
                    <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa-solid fa-chart-pie mr-3 opacity-50"></i> Dashboard
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('attendances.index')" :active="request()->routeIs('attendances.*')">
                        <i class="fa-solid fa-clock mr-3 opacity-50"></i> Présences
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                        <i class="fa-solid fa-list-check mr-3 opacity-50"></i> Tâches
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('leaves.index')" :active="request()->routeIs('leaves.*')">
                        <i class="fa-solid fa-calendar-day mr-3 opacity-50"></i> Congés
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('payroll.index')" :active="request()->routeIs('payroll.*')"> 
                        <i class="fa-solid fa-file-invoice-dollar mr-3 opacity-50"></i> Paie 
                    </x-nav-link-sidebar>

                    <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Administration</div>
                    <x-nav-link-sidebar :href="route('users.index')" :active="request()->routeIs('users.*')">
                        <i class="fa-solid fa-users mr-3 opacity-50"></i> Utilisateurs
                    </x-nav-link-sidebar>

                    <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Outils</div>
                    
                    <x-nav-link-sidebar :href="url('/messages')" :active="request()->is('messages*')">
                        <i class="fa-solid fa-envelope mr-3 opacity-50"></i> Messages
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="url('/documents')" :active="request()->is('documents*')">
                        <i class="fa-solid fa-folder-open mr-3 opacity-50"></i> Documents
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="url('/polls')" :active="request()->is('polls*')">
                        <i class="fa-solid fa-square-poll-vertical mr-3 opacity-50"></i> Sondages
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="url('/evaluations')" :active="request()->is('evaluations*')">
                        <i class="fa-solid fa-star mr-3 opacity-50"></i> Évaluations
                    </x-nav-link-sidebar>
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
        {{-- SYSTÈME DE NOTIFICATION UNIFIÉ --}}
        @if(session('success') || session('error'))
            <x-notification />
        @endif
    </body>
</html>