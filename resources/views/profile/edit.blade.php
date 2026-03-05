<x-app-layout>
    {{-- Header de la page --}}
    <div class="mb-8">
        <h2 class="font-black text-3xl text-white uppercase tracking-tighter flex items-center gap-4">
            <span class="w-2 h-10 bg-blue-600 rounded-full"></span>
            {{ __('Paramètres du Compte') }}
        </h2>
        <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-2 ml-6">Gérez vos informations personnelles et la sécurité</p>
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

        {{-- Section 3 : Danger Zone (Suppression) --}}
        <div class="p-8 sm:p-10 shadow-2xl rounded-[3rem] border border-red-500/10 transition-all hover:border-red-500/20" style="background-color: #111827;">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>