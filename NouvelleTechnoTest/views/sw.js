// On install - caching the application shell
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('sw-cache').then(function(cache) {
      // cache any static files that make up the application shell
      return cache.add(
      '/views/company/ajouter.php',
      '/views/company/index.css',
      '/views/company/index.php',
      '/views/company/lire.php',
      '/views/company/modifier.php',
      '/views/company/supprimer.php',
      '/views/login/index.php',
      '/views/login/register.php',
      '/views/main/index.php',
      '/views/default.php',
      '/views/home.php',);
      
    })
  );
});

// On network request
self.addEventListener('fetch', function(event) {
  event.respondWith(
    // Try the cache
    caches.match(event.request).then(function(response) {
      //If response found return it, else fetch again
      return response || fetch(event.request);
    })
  );
});
  