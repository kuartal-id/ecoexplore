/* Ecoexplore service worker: offline shell for the PWA.
 * - Static assets (/assets/*): stale-while-revalidate.
 * - Public pages: network first, cached copy when offline, then /offline.
 * - Never caches personal pages (account, bookings, checkout, admin, auth) or non-GET requests.
 * Bump VERSION when changing this file's caching behaviour. */
const VERSION = 'eco-v6';
const SHELL = ['/offline', '/assets/app.css', '/assets/app.js', '/manifest.webmanifest?v=2',
  '/assets/logos/ecoexplore-logo-light.png', '/assets/logos/ecoexplore-logo-dark.png',
  '/assets/icons/icon-192.png?v=2', '/assets/img/photos/hero.jpg'];
const PUBLIC_PAGES = /^\/($|explore|journeys\/|directory\/|restore|carbon|about|terms|privacy)/;
const PRIVATE = /^\/(account|bookings|book\/|admin|login|register|logout|auth|forgot-password|reset-password|locale)/;

self.addEventListener('install', (event) => {
  event.waitUntil(caches.open(VERSION).then((cache) => cache.addAll(SHELL)).then(() => self.skipWaiting()));
});

self.addEventListener('activate', (event) => {
  event.waitUntil(caches.keys().then((keys) => Promise.all(keys.filter((k) => k !== VERSION).map((k) => caches.delete(k))))
    .then(() => self.clients.claim()));
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return;
  const url = new URL(req.url);
  if (url.origin !== self.location.origin || PRIVATE.test(url.pathname)) return;

  if (url.pathname.startsWith('/assets/')) {
    event.respondWith(caches.open(VERSION).then(async (cache) => {
      const cached = await cache.match(req);
      const network = fetch(req).then((res) => { if (res.ok) cache.put(req, res.clone()); return res; }).catch(() => cached);
      return cached || network;
    }));
    return;
  }

  if (req.mode === 'navigate') {
    event.respondWith(fetch(req).then((res) => {
      if (res.ok && PUBLIC_PAGES.test(url.pathname) && !url.search) {
        const copy = res.clone();
        caches.open(VERSION).then((cache) => cache.put(req, copy));
      }
      return res;
    }).catch(async () => (await caches.match(req)) || caches.match('/offline')));
  }
});
