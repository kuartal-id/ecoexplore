<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * The repository root is the web root on Hostinger Git deploy, so /.htaccess is the only
 * thing between the internet and .env, the database, logs and booking data. This evaluates
 * its rules offline (PCRE ~ Apache's regex engine). The same deny list is checked against
 * real Apache in CI and against the live site by bin/check-webroot.sh.
 */
class WebRootHtaccessTest extends TestCase
{
    /** @return array{rules: list<array{0:string,1:bool}>, files: string, acme: string} */
    private static function rules(): array
    {
        $htaccess = file_get_contents(dirname(__DIR__, 2).'/.htaccess');

        preg_match_all('/^\s*RewriteRule\s+(\S+)\s+-\s+\[([^\]]*F[^\]]*)\]/m', $htaccess, $m, PREG_SET_ORDER);
        $rules = array_map(fn ($r) => [$r[1], str_contains($r[2], 'NC')], $m);

        preg_match('/<FilesMatch "([^"]+)">/', $htaccess, $files);
        preg_match('/^\s*RewriteRule\s+(\S+)\s+-\s+\[L\]/m', $htaccess, $acme);

        return ['rules' => $rules, 'files' => $files[1] ?? '', 'acme' => $acme[1] ?? ''];
    }

    /** Would Apache refuse this URL path (no leading slash, as in per-directory context)? */
    private static function denied(string $path): bool
    {
        $r = self::rules();
        $path = ltrim(rawurldecode($path), '/');

        if ($r['acme'] !== '' && preg_match('#'.$r['acme'].'#', $path)) {
            return false;
        }

        foreach ($r['rules'] as [$pattern, $nocase]) {
            if (preg_match('#'.$pattern.'#'.($nocase ? 'i' : ''), $path)) {
                return true;
            }
        }

        $basename = basename($path === '' ? '/' : $path);

        return $basename !== '' && (bool) preg_match('#'.$r['files'].'#', $basename);
    }

    public static function deniedPaths(): array
    {
        $paths = [
            '.env', '.env.save', '.env.backup', '.env.production', '.env.example', 'public/.env',
            '.git/config', '.git/HEAD', '.git/objects/ab/cdef', '.github/workflows/build-deploy-branch.yml',
            '.gitignore', '.htaccess', 'public/.htaccess',
            'composer.json', 'composer.lock', 'package.json', 'package-lock.json', 'artisan', 'phpunit.xml', 'phpunit.xml.dist', 'vite.config.js',
            'README.md', 'AGENTS.md', 'docs/STATUS.md', 'docs/DEPLOY.md', 'docs/PAYMENTS.md', 'lang/id/ui.php', 'config/deploy.php',
            'app/Models/User.php', 'APP/Models/User.php', 'app', 'bootstrap/app.php', 'bootstrap/deploy-build.json',
            'bootstrap/cache/config.php', 'config/app.php', 'database/database.sqlite', 'database/migrations/x.php',
            'routes/web.php', 'resources/views/welcome.blade.php', 'tests/TestCase.php', 'bin/check-webroot.sh',
            'storage/logs/laravel.log', 'storage/app/private/bookings/export.csv', 'storage/app/deployed_sha',
            'storage/framework/sessions/abc', 'Storage/logs/laravel.log', 'vendor/autoload.php', 'Vendor/autoload.php',
            'node_modules/vite/package.json', 'laravel.log', 'public/laravel.log', 'error_log', 'public/error_log',
            'backup.sql', 'db.sqlite', 'database.sqlite3', 'x.env', 'id_rsa.pem', 'oauth-private.key', '.env%00',
        ];

        return array_combine($paths, array_map(fn ($p) => [$p], $paths));
    }

    #[DataProvider('deniedPaths')]
    public function test_path_is_refused(string $path): void
    {
        $this->assertTrue(self::denied($path), "/{$path} must be refused by /.htaccess");
    }

    public static function publicPaths(): array
    {
        $paths = [
            '', 'explore', 'journeys/gili-dive-reef-guardians', 'directory/accommodations', 'directory/transport/car-driver-full-day',
            'restore', 'restore/gili-reef-frame-restoration', 'carbon', 'about', 'terms', 'privacy', 'offline',
            'book/journey/rinjani-responsible-trek', 'bookings/ECO-261006-ABCDEF', 'bookings/ECO-261006-ABCDEF/payment-method',
            'login', 'register', 'forgot-password', 'reset-password/token', 'account', 'locale/en',
            'admin', 'admin/bookings/ECO-261006-ABCDEF', 'admin/journeys/1/edit', 'admin/listings/create',
            'auth/kuartal-id/redirect', 'auth/kuartal-id/callback', 'up', 'favicon.ico', 'robots.txt', 'sitemap.xml',
            'manifest.webmanifest', 'sw.js', 'assets/app.css', 'assets/app.js', 'assets/img/reef.svg',
            'assets/logos/ecoexplore-logo-light.png', 'assets/logos/ecoexplore-logo-dark.png',
            'assets/icons/icon-192.png', 'assets/icons/apple-touch-icon.png',
            '.well-known/acme-challenge/token123',
        ];

        return array_combine(array_map(fn ($p) => "/{$p}", $paths), array_map(fn ($p) => [$p], $paths));
    }

    #[DataProvider('publicPaths')]
    public function test_public_path_is_served(string $path): void
    {
        $this->assertFalse(self::denied($path), "/{$path} must not be refused by /.htaccess");
    }

    public function test_every_application_route_is_reachable(): void
    {
        $routes = file_get_contents(dirname(__DIR__, 2).'/routes/web.php');
        preg_match_all("/Route::(?:get|post|put|patch|delete|match|any|view|redirect)\(\s*'([^']*)'/", $routes, $m);

        $this->assertNotEmpty($m[1]);

        foreach ($m[1] as $uri) {
            $sample = preg_replace('/\{[^}]+\}/', 'x', ltrim($uri, '/'));
            $this->assertFalse(self::denied($sample), "Route /{$uri} would be blocked by /.htaccess");
        }
    }

    public function test_rewrites_everything_else_into_public_and_disables_listings(): void
    {
        $htaccess = file_get_contents(dirname(__DIR__, 2).'/.htaccess');

        $this->assertMatchesRegularExpression('/^Options -Indexes/m', $htaccess);
        $this->assertStringContainsString('RewriteCond %{REQUEST_URI} !^/public/', $htaccess);
        $this->assertMatchesRegularExpression('#^\s*RewriteRule \^\(\.\*\)\$ public/\$1 \[L\]#m', $htaccess);
        $this->assertStringContainsString('<IfModule !mod_rewrite.c>', $htaccess, 'Without mod_rewrite everything must be denied.');
    }

    public function test_data_directories_carry_their_own_deny_all(): void
    {
        foreach (['storage', 'database', 'bootstrap'] as $dir) {
            $file = dirname(__DIR__, 2)."/{$dir}/.htaccess";
            $this->assertFileExists($file);
            $this->assertStringContainsString('Require all denied', file_get_contents($file));
        }
    }
}
