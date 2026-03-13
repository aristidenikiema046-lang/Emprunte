<x-app-layout>
    {{-- Message d'erreur flash si redirection par le Middleware --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl flex items-center gap-3 animate-pulse">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-red-500 text-xs font-black uppercase tracking-widest">
                {{ session('error') }}
            </p>
        </div>
    @endif

    <div class="mb-8">
        <h2 class="font-black text-3xl text-white uppercase tracking-tighter flex items-center gap-4">
            <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
            {{ __('Paramètres du Compte') }}
        </h2>
        <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-2 ml-6">
            Gérez vos informations personnelles <span class="text-red-500">(Photo obligatoire)</span>
        </p>
    </div>

    <div class="space-y-8">
        {{-- Section 1 : Informations du Profil --}}
        <div class="p-8 sm:p-10 shadow-2xl rounded-[3rem] border border-white/5 transition-all hover:border-blue-500/20" style="background-color: #111827;">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Section 2 : Mot de passe --}}
        <div class="p-8 sm:p-10 shadow-2xl rounded-[3rem] border border-white/5 transition-all hover:border-blue-500/20" style="background-color: #111827;">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Section 3 : Danger Zone --}}
        <div class="p-8 sm:p-10 shadow-2xl rounded-[3rem] border border-red-500/10 transition-all hover:border-red-500/20" style="background-color: #111827;">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>