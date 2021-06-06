var staticCacheName = "gppc-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/images/icons/favicon.png',
    '/images/icons/favicon-16x16.png',
    '/images/icons/favicon-33x33.png',
    '/images/icons/favicon-49x49.png',
    '/images/icons/favicon-57x57.png',
    '/images/icons/favicon-64x64.png',
    '/images/icons/favicon-60x60.png',
    '/images/icons/favicon-76x76.png',
    '/images/icons/favicon-72x72.png',
    '/images/icons/favicon-114x114.png',
    '/images/icons/favicon-120x120.png',
    '/images/icons/favicon-152x152.png',
    '/images/icons/favicon-144x144.png'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("gppc-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});