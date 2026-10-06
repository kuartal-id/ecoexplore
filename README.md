# Ecoexplore

Ecoexplore is a Kuartal-owned Indonesian startup for eco, regenerative and geotourism
travel. This repository is the **Laravel 12 MVP**: curated Lombok journeys, stays, food,
attractions, eco shops, transport and guides, a restoration marketplace (coral, mangrove,
forest/watershed), a trip carbon estimator, and booking records with a confirmation flow.
**Online payment is the only thing left to build**: bookings store the customer's
chosen method (card / bank transfer / e-wallet) with `payment_status = pending`, and admins
confirm bank transfers by hand. See [docs/PAYMENTS.md](docs/PAYMENTS.md).

All journeys, listings, partners, prices and restoration projects are **sample content**,
clearly labelled on the site, until the owner replaces them.

## Stack

- PHP 8.4, Laravel 12, no Node build: CSS/JS are plain files in `public/assets/`
  (`app.css` is the design system from the product spec plus an extensions block).
- MySQL in production (Hostinger), SQLite locally and in tests.
- Indonesian by default, English via the toggle (`lang/id`, `lang/en`; catalogue content is
  stored as `{"id": ..., "en": ...}` JSON).
- Light/dark mode (`.dark` on `<html>`, remembered in `localStorage`, defaults to the OS).
- PWA: `public/manifest.webmanifest` + `public/sw.js` (offline page, never caches private pages).
- Sign-in: **Masuk dengan Kuartal ID** (OIDC against id.kuartal.id, PKCE S256 + state +
  nonce, RS256 id_token via JWKS) **and** local email/password. Guests can book.

## Run locally

```sh
composer install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed          # sample content, seeded once (idempotent)
php artisan serve                   # http://localhost:8000
php artisan ecoexplore:admin you@example.com   # after registering, grants /admin
php artisan test
```

Emails (booking received / confirmed) go to `storage/logs/laravel.log` while
`MAIL_MAILER=log`.

## Where things are

| Area | Code |
|---|---|
| Journeys, directory, restoration, carbon | `app/Http/Controllers/*Controller.php`, `resources/views/{journeys,directory,restore,carbon}` |
| Checkout and bookings | `CheckoutController`, `BookingController`, `app/Services/BookingService.php` |
| Payment state (the only place it changes) | `app/Services/Payments/BookingPayments.php` |
| Carbon estimator (illustrative factors) | `app/Services/CarbonEstimator.php`, `config/carbon.php` |
| Kuartal ID | `app/Http/Controllers/Auth/KuartalIdLoginController.php`, `app/Support/KuartalId/*`, `config/services.php` |
| Admin | `app/Http/Controllers/Admin/*`, `/admin` (users with `is_admin`) |
| Sample content | `database/seeders/data/*.php`, `SampleContentSeeder` |
| Logos / icons | `public/assets/logos/ecoexplore-logo-{light,dark}.png`, `public/assets/icons/*`, `public/favicon.ico` |
| Illustrations | `public/assets/img/*.svg` (placeholders) |

**Replacing the logo:** overwrite `public/assets/logos/ecoexplore-logo-light.png` (for light
backgrounds) and `ecoexplore-logo-dark.png` (for dark backgrounds) with files of the same
name. A wide transparent PNG around 4:1 works best. Nothing else needs to change.

## Carbon methodology

The carbon calculator uses clearly labelled illustrative MVP factors. They are not an
audited carbon accounting methodology and must not be advertised as verified offsets.
Before production launch, create a versioned methodology with source/factor evidence,
transport classes, accommodation methodology, food factors, uncertainty handling, project
additionality and impact reporting. The factor set is versioned in `config/carbon.php`
(`version`) and shown on the page.

## Deploy

Hostinger shared hosting via hPanel Git, using a generated `deploy` branch. See
[docs/DEPLOY.md](docs/DEPLOY.md). Status and open items: [docs/STATUS.md](docs/STATUS.md).
Agent/contributor rules: [AGENTS.md](AGENTS.md).
