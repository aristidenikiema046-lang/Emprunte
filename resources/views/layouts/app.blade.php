<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Emprunte') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            <nav class="w-64 bg-gray-900 text-white flex flex-col">
                <div class="p-6 text-2xl font-bold border-b border-gray-800">
                    Empruntef
                </div>
                
                <div class="flex-1 overflow-y-auto py-4">
                    <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('attendances.index')" :active="request()->routeIs('attendances.index')">
                        Présences
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                        Tâches
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('leaves.index')" :active="request()->routeIs('leaves.index')">
                        Congés
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('payroll.index')" :active="request()->routeIs('payroll.index')"> Paie </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('users.index')" :active="request()->routeIs('users.index')">
                        Utilisateurs
                    </x-nav-link-sidebar>
                    
                    <x-nav-link-sidebar :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        Messages
                    </x-nav-link-sidebar>

                    <div x-data="{ open: {{ request()->routeIs('documents.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-all focus:outline-none">
                            <span class="text-sm font-semibold">Documents</span>
                            <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-cloak class="bg-gray-800/50 pb-2">
                            <x-nav-link-sidebar :href="route('documents.received')" :active="request()->routeIs('documents.received')">
                                <span class="text-xs ml-4">Docs reçus</span>
                            </x-nav-link-sidebar>
                            
                            <x-nav-link-sidebar :href="route('documents.sent')" :active="request()->routeIs('documents.sent')">
                                <span class="text-xs ml-4">Docs envoyés</span>
                            </x-nav-link-sidebar>
                            
                            <x-nav-link-sidebar :href="route('documents.create')" :active="request()->routeIs('documents.create')">
                                <span class="text-xs ml-4">Envoyer un doc</span>
                            </x-nav-link-sidebar>
                        </div>
                    </div>

                    <x-nav-link-sidebar :href="route('polls.index')" :active="request()->routeIs('polls.*')">
                        Sondages
                    </x-nav-link-sidebar>

                    <x-nav-link-sidebar :href="route('evaluations.index')" :active="request()->routeIs('evaluations.*')">
                        <div class="flex items-center">
                            <span>Évaluations</span>
                            <span class="ml-2 bg-blue-600 text-[10px] px-1.5 py-0.5 rounded uppercase font-black tracking-tighter"></span>
                        </div>
                    </x-nav-link-sidebar>
                </div>
                

                <div class="p-4 border-t border-gray-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white text-sm">Déconnexion</button>
                    </form>
                </div>
            </nav>

            <main class="flex-1 overflow-y-auto p-8">
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>
</html>