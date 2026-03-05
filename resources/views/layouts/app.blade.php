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
    <body class="font-sans antialiased text-slate-200" style="background-color: #020617;"> {{-- bg-slate-950 force --}}
        <div class="flex h-screen overflow-hidden bg-slate-950">
            
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

                    <div x-data="{ open: {{ request()->routeIs('documents.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-all focus:outline-