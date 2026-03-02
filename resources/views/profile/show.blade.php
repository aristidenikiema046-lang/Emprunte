<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Header --}}
            <div class="bg-gray-900 rounded-3xl p-8 border border-gray-800 shadow-2xl flex items-center gap-6">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff" class="w-24 h-24 rounded-full border-4 border-gray-800">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase">{{ $user->name }}</h2>
                    <p class="text-blue-500 font-bold">{{ $user->post ?? 'Collaborateur' }}</p>
                    <p class="text-gray-500 text-xs">{{ $user->employee_id ?? 'ID: EMP-001' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Infos Personnelles --}}
                <div class="bg-gray-900 rounded-3xl p-6 border border-gray-800 space-y-4">
                    <h3 class="text-white font-bold mb-4">Informations Personnelles</h3>
                    
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-800 border-none rounded-xl text-white text-sm mt-1">
                    </div>

                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-800 border-none rounded-xl text-white text-sm mt-1">
                    </div>

                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Ex: +225..." class="w-full bg-gray-800 border-none rounded-xl text-white text-sm mt-1">
                    </div>
                </div>

                {{-- Sécurité --}}
                <div class="bg-gray-900 rounded-3xl p-6 border border-gray-800 space-y-4">
                    <h3 class="text-white font-bold mb-4">Changer le mot de passe</h3>
                    
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="w-full bg-gray-800 border-none rounded-xl text-white text-sm mt-1">
                    </div>

                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Nouveau mot de passe</label>
                        <input type="password" name="new_password" class="w-full bg-gray-800 border-none rounded-xl text-white text-sm mt-1">
                    </div>

                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest">Confirmer</label>
                        <input type="password" name="new_password_confirmation" class="w-full bg-gray-800 border-none rounded-xl text-white text-sm mt-1">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-lg shadow-blue-500/20">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</x-app-layout>