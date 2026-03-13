<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-white uppercase tracking-widest">
            {{ __('Supprimer le compte') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400 italic">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.') }}
        </p>
    </header>

    <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest transition"
        x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Supprimer le compte') }}
    </button>

    {{-- Note: Si ton système de Modal (x-modal) plante aussi, il faudra remplacer la modal par un simple formulaire de confirmation --}}
</section>