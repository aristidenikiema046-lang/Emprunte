<section>
    <header>
        <h2 class="text-lg font-bold text-white uppercase tracking-widest">
            {{ __('Modifier le mot de passe') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400 italic">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Mot de passe actuel') }}</label>
            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" autocomplete="current-password" />
            @if($errors->updatePassword->has('current_password'))
                <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="password" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Nouveau mot de passe') }}</label>
            <input id="password" name="password" type="password" class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" autocomplete="new-password" />
            @if($errors->updatePassword->has('password'))
                <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="password_confirmation" class="block text-gray-500 uppercase text-[10px] font-black mb-2">{{ __('Confirmer le mot de passe') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-slate-900 border-white/5 text-white rounded-xl focus:ring-blue-600 focus:border-blue-600 px-4 py-3" autocomplete="new-password" />
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest transition shadow-lg shadow-blue-600/20">
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-500 font-bold italic">
                    {{ __('Enregistré avec succès.') }}
                </p>
            @endif
        </div>
    </form>
</section>