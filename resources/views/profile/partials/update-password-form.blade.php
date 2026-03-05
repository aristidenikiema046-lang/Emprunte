<section class="bg-[#111827] rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
    
    <div class="bg-[#1e293b]/30 p-8 border-b border-white/5">
        <h2 class="text-xl font-black text-white uppercase tracking-tighter">
            Sécurité <span class="text-blue-500">Compte</span>
        </h2>
        <p class="mt-1 text-[10px] font-bold text-gray-500 uppercase tracking-[0.3em]">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="p-8 space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Password Actuel --}}
            <div class="space-y-3 md:col-span-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">{{ __('Current Password') }}</label>
                <input id="update_password_current_password" name="current_password" type="password" 
                       class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-blue-500/20 transition-all" autocomplete="current-password">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            {{-- Nouveau Password --}}
            <div class="space-y-3">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">{{ __('New Password') }}</label>
                <input id="update_password_password" name="password" type="password" 
                       class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-blue-500/20 transition-all" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            {{-- Confirmation --}}
            <div class="space-y-3">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">{{ __('Confirm Password') }}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                       class="w-full bg-[#0b0f1a] border-none rounded-2xl py-4 px-6 text-white font-bold shadow-inner focus:ring-2 focus:ring-blue-500/20 transition-all" autocomplete="new-password">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-[0.2em] text-[10px] rounded-xl shadow-xl shadow-blue-900/40 transition-all active:scale-95">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" 
                   class="text-[10px] font-black text-teal-400 uppercase tracking-widest animate-pulse">
                    <i class="fa-solid fa-check-double mr-1"></i> {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>