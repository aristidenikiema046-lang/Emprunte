<section>
    <header>
        <h2 class="text-lg font-bold text-white uppercase tracking-widest">
            {{ __('Informations du Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400 italic">
            {{ __("Mettez à jour vos informations personnelles et votre photo de profil.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Section Avatar Dark --}}
        <div class="flex items-center gap-6 p-6 rounded-[2rem] border border-white/5 shadow-inner" style="background-color: #0b0f1a;">
            <div class="relative">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                     class="w-24 h-24 rounded-3xl object-cover border-2 border-blue-500 shadow-lg">
            </div>
            <div class="flex-1">
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Photo de profil</label>
                <input type="file" name="avatar" class="block w-full text-xs text-gray-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-[10px] file:font-black file:uppercase
                    file:bg-blue-600 file:text-white
                    hover:file:bg-blue-700 transition-all cursor-pointer">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nom --}}
            <div>
                <label for="name" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Nom complet') }}</label>
                <input id="name" name="name" type="text" 
                    class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" 
                    value="{{ old('name', $user->name) }}" required autofocus />
                @if($errors->has('name'))
                    <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $errors->first('name') }}</p>
                @endif
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" 
                    class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" 
                    value="{{ old('email', $user->email) }}" required />
                @if($errors->has('email'))
                    <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $errors->first('email') }}</p>
                @endif
            </div>

            {{-- Téléphone --}}
            <div>
                <label for="phone" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Téléphone') }}</label>
                <input id="phone" name="phone" type="text" 
                    class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" 
                    value="{{ old('phone', $user->phone) }}" />
            </div>

            {{-- Adresse --}}
            <div class="md:col-span-2">
                <label for="address" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Adresse de résidence') }}</label>
                <input id="address" name="address" type="text" 
                    class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" 
                    value="{{ old('address', $user->address) }}" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest transition shadow-lg shadow-blue-600/20">
                {{ __('Enregistrer les changements') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-500 font-bold italic">
                    {{ __('Profil mis à jour avec succès.') }}
                </p>
            @endif
        </div>
    </form>
</section>