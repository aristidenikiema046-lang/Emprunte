<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            // On utilise des guillemets pour que VS Code voit une chaîne de caractères
            const swPath = "{{ asset('sw.js') }}";
            
            navigator.serviceWorker.register(swPath)
                .then(reg => console.log('SW OK'))
                .catch(err => console.log('SW Erreur', err));
        });
    }
</script>