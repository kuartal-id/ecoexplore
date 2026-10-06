/* Ecoexplore front-end (no build step). Theme toggle, PWA service worker, checkout total. */
(function () {
  'use strict';

  // Light / dark mode (initial class is set inline in <head> to avoid a flash).
  document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var dark = document.documentElement.classList.toggle('dark');
      try { localStorage.setItem('eco-theme', dark ? 'dark' : 'light'); } catch (e) {}
    });
  });

  // PWA: register the service worker (scope "/").
  if ('serviceWorker' in navigator && location.protocol !== 'file:') {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register('/sw.js').catch(function () {});
    });
  }

  // Checkout: live total preview. The server always recomputes the real amount.
  var form = document.querySelector('[data-checkout]');
  if (form) {
    var unit = parseInt(form.getAttribute('data-unit'), 10) || 0;
    var isStay = form.getAttribute('data-stay') === '1';
    var qty = form.querySelector('[data-qty]');
    var start = form.querySelector('[data-start]');
    var end = form.querySelector('[data-end]');
    var fmt = function (n) { return 'Rp ' + n.toLocaleString('id-ID'); };
    var update = function () {
      var q = Math.max(1, parseInt(qty && qty.value, 10) || 1);
      var nights = 1;
      if (isStay && start && end && start.value && end.value) {
        var d = (new Date(end.value) - new Date(start.value)) / 86400000;
        nights = d > 0 ? Math.round(d) : 1;
      }
      var total = unit * q * (isStay ? nights : 1);
      document.querySelectorAll('[data-total]').forEach(function (el) { el.textContent = fmt(total); });
      document.querySelectorAll('[data-qty-out]').forEach(function (el) { el.textContent = q; });
      document.querySelectorAll('[data-nights-out]').forEach(function (el) { el.textContent = nights; });
      if (isStay && start && end && start.value) { end.min = start.value; }
    };
    [qty, start, end].forEach(function (el) { if (el) { el.addEventListener('input', update); el.addEventListener('change', update); } });
    update();
  }
})();
