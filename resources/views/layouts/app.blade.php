<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Emprunte') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-200" style="background-color: #020617;">
    <div class="flex h-screen overflow-hidden bg-slate-950">
        
        <nav class="w-64 bg-gray-900 text-white flex flex-col border-r border-gray-800">
            <div class="p-6 text-xl font-bold border-b border-gray-800 flex items-center gap-3">
                <span class="bg-indigo-600 p-2 rounded-lg text-xs italic">E</span> Emprunte
            </div>
            
            <div class="flex-1 overflow-y-auto py-4">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('dashboard') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <i class="fa-solid fa-chart-pie mr-3 opacity-50"></i> Tableau de bord
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

                @if(auth()->user()->role === 'admin')
                    <div class="px-6 mt-6 mb-2 text-[10px] uppercase font-black text-gray-500 tracking-widest">Administration</div>
                    <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 text-xs font-bold {{ request()->routeIs('users.*') ? 'text-white bg-blue-600/20 border-r-4 border-blue-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fa-solid fa-users mr-3 opacity-50"></i> Utilisateurs
                    </a>
                @endif
            </div>
        </nav>

        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-8 z-40">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle text-[8px] text-emerald-500 animate-pulse"></i>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-tighter">SYSTÈME CONNECTÉ</span>
                </div>

                <div class="flex items-center gap-6">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative text-gray-400 hover:text-white transition-colors">
                            <i class="fa-solid fa-bell text-lg"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block border-r border-gray-800 pr-4">
                            <p class="text-xs font-black text-white leading-none uppercase">{{ Auth::user()->name }}</p>
                        </div>
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff' }}" 
                             class="w-10 h-10 rounded-xl border-2 border-gray-800 shadow-lg">
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-10" style="background-color: #020617;">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>