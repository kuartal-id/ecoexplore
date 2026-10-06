# Ecoexplore: status

_Last updated 2026-10-06 (MVP PR `ai/grok/mvp`)._

## Built

- **Marketing site + PWA.** Home, About, Terms, Privacy, offline page, dynamic `robots.txt`
  and `sitemap.xml`, `manifest.webmanifest`, `sw.js` (offline shell; never caches private pages).
- **Travel-app UI.** Responsive throughout; on phones there's a bottom tab bar, a sticky price/"choose
  date" bar on journeys and a sticky total/submit bar at checkout; on tablets in landscape a
  persistent sidebar rail. Light/dark mode (OS default, toggle remembered). Indonesian by
  default, English toggle (session + cookie + user preference).
- **9 Lombok journeys** (sample copy, itineraries, inclusions, impact, IDR per-person prices),
  with category filters and search.
- **Directory:** accommodations, culinary, attractions, eco shops, transport, guides,
  including sample flight and fast-boat concierge, car + driver, airport transfer and a
  Rinjani trekking organiser. Stays, transport and guides can be booked; the others are info.
- **Restoration marketplace:** 6 sample projects (coral, mangrove, forest/watershed) to
  fund/adopt by the unit. Progress starts at 0 and only paid contributions count.
- **Carbon estimator** with illustrative, versioned factors (`config/carbon.php`), the README
  disclaimer shown on the page, and a link to restoration that is explicitly not an offset.
- **Bookings:** guest or signed-in checkout, server-side pricing (stays = rooms × nights),
  `ECO-YYMMDD-XXXXXX` reference, `source_site=ecoexplore`, purpose / item type / item id, payer,
  `amount_idr`, payment method (card / bank transfer / e-wallet), `payment_status=pending`,
  status, `paid_at`, audit trail (`booking_events`), "received" email, private confirmation
  page (session, owner, admin or emailed `?t=` link), payment-method change.
- **Payments-ready core:** `BookingPayments::markPaid()` (idempotent, amount check, automatic
  fulfilment + confirmation email). See `docs/PAYMENTS.md`.
- **Accounts:** Masuk dengan Kuartal ID (OIDC, PKCE S256, state, nonce, RS256/JWKS; ported
  from careers) + local email/password with registration and password reset; RP logout.
- **Admin** (`is_admin`, granted by `php artisan ecoexplore:admin <email>`): dashboard,
  bookings list/search/filter, booking detail with events, manual **mark paid** for
  confirmed transfers, cancel; CRUD for journeys and listings (bilingual fields).
- **Deploy readiness:** careers' Hostinger pattern (workflow, root `.htaccess`, webroot
  checks, `app:post-deploy` with `.env` chmod 600, `config/deploy.php`), MySQL in production,
  SQLite in tests, idempotent sample-content seeder. See `docs/DEPLOY.md`.
- **Tests:** `php artisan test` (pages, booking flow, payments, Kuartal ID, local auth,
  admin access, carbon, locale, seeders, web-root rules, post-deploy).

## Stubbed / not built

- **Online payment gateway** (Midtrans or the planned central Kuartal integration): design in
  `docs/PAYMENTS.md`. Card and e-wallet bookings stay pending until then.
- Refunds, inventory/availability calendars, partner accounts, reviews, restoration
  certificates/impact reports, and editing restoration projects in admin (seeded only for now).
- Emails go to the log mailer until SMTP is configured.

## Needs the owner

- **Real logos**: replace `public/assets/logos/ecoexplore-logo-{light,dark}.png`, and
  regenerate `public/assets/icons/*` + `public/favicon.ico` from the real mark.
- **Photos**: the `public/assets/img/*.svg` illustrations are placeholders.
- **Real content**: journeys, prices, itineraries, community partners, listings (all sample
  business names), restoration partners, unit prices and targets.
- **Business details**: contact email, WhatsApp, legal entity, ops inbox, bank account for
  transfers (`ECOEXPLORE_*` env vars). The site shows neutral wording until they are set.
- **Terms & Privacy**: the pages are structured drafts with `[SUPPLY]` placeholders; they need
  legal review (PDP Law / UU 27/2022, cancellation and refund policy, tour operator licence).
- **Carbon methodology**: versioned factors with sources before launch (README requirement).
- **Kuartal ID client** for this site (redirect `https://<domain>/auth/kuartal-id/callback`).
- **Domain, Hostinger setup, MySQL, SMTP, cron**: `docs/DEPLOY.md`.
