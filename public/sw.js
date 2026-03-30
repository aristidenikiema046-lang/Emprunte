self.addEventListener('install', (e) => {
    console.log('[Service Worker] Install');
});

self.addEventListener('fetch', (e) => {
    // Permet de charger l'app même hors-ligne si configuré plus tard
    e.respondWith(fetch(e.request));
});