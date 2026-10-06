# Deploying Ecoexplore (Hostinger shared hosting, hPanel Git)

Status: **not deployed yet.** Nothing has been set up on Hostinger. The owner does the
merge and cutover. This is the same pattern as careers.kuartal.id, ported from careers
`main`, including the PR #3 change that resets `.env` to mode 600 on every post-deploy run.

## How it works

```
push to main ──► GitHub Actions: .github/workflows/build-deploy-branch.yml
                   • composer validate, composer install, php artisan test (FULL suite)
                   • deploy/build-release.sh:
                       composer install --no-dev -o            → vendor/
                       strip require-dev from composer.json/lock (Hostinger's composer run = no-op)
                       (no Node build: CSS/JS are plain files in public/assets)
                   • deploy/test-webroot-apache.sh: serve the tree with real Apache + its
                     .htaccess files, run bin/check-webroot.sh
                   • commit the tree to branch `deploy` (GITHUB_TOKEN only, no other secrets)
                                │
                                ▼  Hostinger GitHub App webhook (push to `deploy`)
hPanel Git: pulls `deploy` into ~/domains/<domain>/public_html
            (runs `composer install`, which finds nothing to do; keeps gitignored paths:
             .env, storage/*, bootstrap/cache/*)
                                │
                                ▼  hPanel cron, every minute
php artisan app:post-deploy: new release? → lock → migrate --force
                              → db:seed SampleContentSeeder (no-op after the first run)
                              → optimize:clear → optimize → write storage/app/deployed_sha
                              (+ every run: put .env back to 0600)
```

Pull requests run the tests, the build and the Apache check but never publish. **Merging to
`main` publishes `deploy`**; Hostinger only picks it up once hPanel Git is connected (below).

Details carried over from careers:
- `vendor/` is committed on `deploy` and `require-dev` is stripped from `composer.json` and
  `composer.lock` (production versions verified identical), so Hostinger's automatic
  `composer install` prints "Nothing to install, update or remove".
- `app:post-deploy` reads the release from `bootstrap/deploy-build.json` (written by the build),
  falling back to `.git/HEAD` (`exec()` is disabled on Hostinger). It is silent when nothing
  changed, holds a `flock()`, writes the `deployed_sha` marker only after every step succeeded,
  logs failures to `storage/logs/laravel.log` and retries a failed release every 5 minutes.
  Steps are in `config/deploy.php`.
- **Known window (≤ 1 minute after each deploy):** new code may run against the old schema
  until the cron runs. Ship columns before the code that needs them.
- Requires **PHP 8.4** (locked Symfony packages need ≥ 8.4.1).

## Web-root safety

The repository root **is** the web root. `/.htaccess` returns 403 for dotfiles/dot-dirs,
framework directories (`app bootstrap config database resources routes storage tests vendor
node_modules docs deploy bin lang`), `composer.*`, `artisan`, `phpunit.xml`, `*.md`, `*.log`,
`*.sqlite`, `*.sql`, `*.key`, `*.pem`, backups and `error_log`, and rewrites everything else into
`public/`. Unlike careers, `.xml` is **not** refused by extension, because `/sitemap.xml` is a
Laravel route (phpunit.xml is still refused by name). Checked three ways:

| Where | What |
|---|---|
| `tests/Unit/WebRootHtaccessTest.php` | rules evaluated offline; every app route reachable |
| CI → `deploy/test-webroot-apache.sh` | real Apache; every denied path is created as a real file first |
| `bin/check-webroot.sh https://<domain>` | the live site, after the cutover and any `.htaccess` change |

## Production environment

Set in `~/domains/<domain>/public_html/.env` (mode 600; never commit it):

```dotenv
APP_NAME=Ecoexplore
APP_ENV=production
APP_KEY=                       # php artisan key:generate --show (once), keep it forever
APP_DEBUG=false
APP_URL=https://<domain>
APP_TIMEZONE=Asia/Makassar
APP_LOCALE=id
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1              # hPanel → Databases shows the host (often localhost)
DB_PORT=3306
DB_DATABASE=<u123_ecoexplore>
DB_USERNAME=<u123_ecoexplore>
DB_PASSWORD=<secret>

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp               # or keep `log` until SMTP is ready
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_SCHEME=smtps
MAIL_USERNAME=<bookings@domain>
MAIL_PASSWORD=<secret>
MAIL_FROM_ADDRESS=<bookings@domain>
MAIL_FROM_NAME=Ecoexplore

KUARTAL_ID_BASE_URL=https://id.kuartal.id
KUARTAL_ID_CLIENT_ID=<from kuartal-login>
KUARTAL_ID_CLIENT_SECRET=<secret>
KUARTAL_ID_REDIRECT_URI=https://<domain>/auth/kuartal-id/callback
KUARTAL_ID_SCOPES="openid profile email"

ECOEXPLORE_CONTACT_EMAIL=<public contact email>
ECOEXPLORE_WHATSAPP=<+62...>
ECOEXPLORE_LEGAL_ENTITY=<PT ...>
ECOEXPLORE_OPS_EMAIL=<ops inbox that receives booking copies>
ECOEXPLORE_BANK_NAME=<bank>
ECOEXPLORE_BANK_ACCOUNT_NAME=<account holder>
ECOEXPLORE_BANK_ACCOUNT_NUMBER=<account number>
ECOEXPLORE_PAYMENT_GATEWAY=none
```

The Kuartal ID client is created in kuartal-id/kuartal-login (`php artisan passport:client`,
confidential, name "ecoexplore-web") with **exactly** the redirect URI above. Until
`KUARTAL_ID_CLIENT_ID` is set the Kuartal ID button shows a friendly "not available yet" message
and local login keeps working.

## First deploy (owner runbook)

1. Merge the PR. The workflow creates the `deploy` branch. Check the run is green and that the
   branch has `vendor/` and `bootstrap/deploy-build.json`.
2. hPanel → the domain → **Advanced → PHP Configuration**: **PHP 8.4**; extensions `pdo_mysql`,
   `mbstring`, `openssl`, `intl`, `fileinfo` (default on Hostinger).
3. hPanel → **Databases → MySQL**: create the database and user; note the host.
4. Make sure `public_html` is empty (Hostinger wants an empty target for the first deploy;
   move any placeholder `index.html`/`default.php` out).
5. hPanel → **Advanced → Git**: connect the GitHub App, repository `kuartal-id/ecoexplore`,
   branch **`deploy`**, directory `public_html`, **Deploy**, auto-deployment on.
6. SSH (CLI `php` may be 8.3; use `/opt/alt/php84/usr/bin/php`):
   ```sh
   PHP=/opt/alt/php84/usr/bin/php
   cd ~/domains/<domain>/public_html
   cp .env.example .env && chmod 600 .env && nano .env      # fill in the values above
   $PHP artisan key:generate --force
   $PHP artisan app:post-deploy        # migrate, seed sample content once, cache
   $PHP artisan ecoexplore:admin <owner-email>   # after registering / signing in once
   ```
7. hPanel → **Advanced → Cron Jobs**, every minute:
   ```
   cd /home/<user>/domains/<domain>/public_html && /opt/alt/php84/usr/bin/php artisan app:post-deploy >/dev/null 2>&1
   ```
8. Verify:
   ```sh
   bin/check-webroot.sh https://<domain>
   curl -sI https://<domain>/auth/kuartal-id/redirect | grep -i location   # id.kuartal.id/oauth/authorize?...code_challenge...nonce...
   ```
   Then book something as a guest, open `/admin`, mark it paid with a test reference, and check
   the confirmation email in the mailer (or `storage/logs/laravel.log` with `MAIL_MAILER=log`).

## Rollback

Revert the commit on `main`; the build publishes a new `deploy` commit and Hostinger deploys it.
`app:post-deploy` never rolls migrations back. If a migration must be undone, do it by hand
(`$PHP artisan migrate:rollback --step=1`) after taking a MySQL backup in hPanel.
