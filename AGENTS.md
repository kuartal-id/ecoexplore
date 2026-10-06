# AGENTS.md: rules for anyone (human or AI) changing Ecoexplore

## Hard rules

1. **Never commit or print secrets.** `.env`, keys, Kuartal ID client secrets, database
   passwords, bank details that aren't public, gateway server keys: none of these go into git,
   PR descriptions, logs or screenshots. `.env.example` holds names only.
2. **Never mark a booking paid from the browser.** Payment state changes only in
   `App\Services\Payments\BookingPayments` and only from (a) a verified gateway notification
   (server-to-server, signature checked) or (b) an admin confirming money arrived. A return or
   redirect URL is *never* proof of payment. See `docs/PAYMENTS.md`.
3. **Prices are computed on the server** (`BookingService::price()`), never accepted from a form.
4. **Honour the carbon disclaimer.** Factors are illustrative; never call results verified
   offsets or claim emissions are "neutralised". Keep the disclaimer and factor version visible.
5. **Sample content stays labelled** until the owner confirms it: keep the "Contoh / Sample"
   chips and notices, and do not invent real business names, licences, legal entities, bank
   accounts or contact details. Leave `[SUPPLY]` placeholders instead.
6. **Web-root safety.** On Hostinger the repository root *is* the web root. Do not weaken
   `/.htaccess`; add new public routes to `tests/Unit/WebRootHtaccessTest.php` and
   `bin/check-webroot.sh`. Never add a first URL segment that matches a framework directory
   (`app`, `config`, `storage`, `docs`, `lang`, ...).
7. **No deploys or production changes from agents** unless the owner asks for that exact action.
   Merging to `main` publishes the `deploy` branch, which Hostinger can pull automatically.
8. **Migrations must be safe for a minute of old code** (`app:post-deploy` runs from cron
   after Hostinger publishes): add columns before code uses them, never rename in one step.
9. **Seeders are idempotent.** `SampleContentSeeder` runs on every release but only seeds once
   (marker `sample-content-v1` in `seed_markers`). Never make it overwrite owner edits; add a
   new marker for new sample sets.

## Conventions

- PHP 8.4 / Laravel 12. No Node build: edit `public/assets/app.css` and `app.js` directly.
  `asset_v()` adds a cache-busting `?v=mtime`. Bump `VERSION` in `public/sw.js` when you change
  caching behaviour.
- Every user-facing string goes through `__('ui....')` with **both** `lang/id/ui.php` and
  `lang/en/ui.php` updated (a test checks the key sets match). Indonesian is the default.
- Catalogue text is bilingual JSON (`HasTranslations::tr()`); admin forms edit both languages.
- Money is integer IDR (`*_idr` columns); format with `idr()`.
- Booking references: `ECO-YYMMDD-XXXXXX`; `source_site = 'ecoexplore'`.
- Light and dark mode both need to look right; check new UI in both and on a phone width.
- Tests: `php artisan test` must stay green. Add a feature test with every behaviour change.

## Useful commands

```sh
php artisan test
php artisan serve
php artisan ecoexplore:admin someone@example.com [--revoke]
php artisan app:post-deploy          # what the production cron runs
bin/check-webroot.sh https://<domain>   # live web-root check after a deploy change
```
