<?php

namespace Tests\Feature;

use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SampleContentSeeder::class);
    }

    /** @return array<string, array{0: string}> */
    public static function pages(): array
    {
        $paths = [
            '/', '/explore', '/explore?category=trek', '/explore?q=rinjani', '/journeys/gili-dive-reef-guardians',
            '/directory/accommodations', '/directory/culinary', '/directory/attractions', '/directory/eco-shops',
            '/directory/transport', '/directory/guides', '/directory/transport/flight-concierge-lombok',
            '/directory/guides/rinjani-trekking-organiser', '/directory/attractions/benang-kelambu-waterfall',
            '/restore', '/restore/east-lombok-mangrove-planting', '/carbon', '/about', '/terms', '/privacy', '/offline',
            '/login', '/register', '/forgot-password', '/book/journey/rinjani-responsible-trek',
            '/book/listing/bamboo-eco-stay-gili-air', '/book/listing/car-driver-full-day', '/book/restore/adopt-a-coral-fragment',
            '/up',
        ];

        return array_combine($paths, array_map(fn ($p) => [$p], $paths));
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $path): void
    {
        $this->get($path)->assertOk();
    }

    public function test_home_shows_brand_logos_pwa_and_featured_journeys(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('assets/logos/ecoexplore-logo-light.png', false)
            ->assertSee('assets/logos/ecoexplore-logo-dark.png', false)
            ->assertSee('manifest.webmanifest', false)
            ->assertSee('assets/app.css', false)
            ->assertSee('<html lang="id"', false);
    }

    public function test_all_nine_lombok_journeys_are_listed_with_idr_prices(): void
    {
        $response = $this->get('/explore')->assertOk();

        $this->assertSame(9, Journey::published()->count());
        foreach ([
            'Gili Dive & Reef Guardians', 'Gili Islands Slow Dive Escape', 'Rinjani Responsible Trek',
            'Rinjani Trek & Mountain Stewardship', 'Sembalun Highlands Slow Escape', 'Remnants of Samalas',
            'Lombok Food & Farm Table', 'Lantan Village Living Culture', 'Aik Berik Geotour',
        ] as $title) {
            $response->assertSee($title);
        }
        $response->assertSee('Rp 2.850.000');
    }

    public function test_journey_page_shows_itinerary_sample_notice_and_book_link(): void
    {
        $journey = Journey::where('slug', 'rinjani-trek-mountain-stewardship')->firstOrFail();

        $this->get('/journeys/'.$journey->slug)
            ->assertOk()
            ->assertSee($journey->tr('title'))
            ->assertSee($journey->itinerary['id'][0]['title'])
            ->assertSee(__('ui.common.sample_notice'))
            ->assertSee(route('checkout.create', ['journey', $journey->slug]), false);
    }

    public function test_directory_has_the_requested_sample_services(): void
    {
        $this->get('/directory/transport')->assertOk()
            ->assertSee(Listing::where('slug', 'flight-concierge-lombok')->first()->name)
            ->assertSee(Listing::where('slug', 'fast-boat-ferry-concierge')->first()->name)
            ->assertSee(Listing::where('slug', 'car-driver-full-day')->first()->name);
        $this->get('/directory/guides')->assertOk()
            ->assertSee(Listing::where('slug', 'rinjani-trekking-organiser')->first()->name);
    }

    public function test_unknown_directory_type_and_unbookable_listing_404(): void
    {
        $this->get('/directory/casinos')->assertNotFound();
        $this->get('/book/listing/benang-kelambu-waterfall')->assertNotFound();
        $this->get('/book/journey/does-not-exist')->assertNotFound();
        $this->get('/book/nonsense/rinjani-responsible-trek')->assertNotFound();
    }

    public function test_unpublished_journey_is_hidden(): void
    {
        Journey::where('slug', 'aik-berik-geotour')->update(['is_published' => false]);

        $this->get('/journeys/aik-berik-geotour')->assertNotFound();
        $this->get('/explore')->assertDontSee('Aik Berik Geotour');
    }

    public function test_restoration_marketplace_covers_coral_mangrove_and_forest(): void
    {
        $response = $this->get('/restore')->assertOk();

        foreach (['coral', 'mangrove', 'forest'] as $type) {
            $this->assertTrue(RestorationProject::where('type', $type)->exists());
        }
        foreach (RestorationProject::all() as $project) {
            $response->assertSee($project->tr('title'));
            $this->assertSame(0, (int) $project->funded_units, 'Progress starts at zero; only paid contributions count.');
        }
    }

    public function test_robots_and_sitemap(): void
    {
        $this->get('/robots.txt')->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap: '.url('/sitemap.xml'), false)
            ->assertSee('Disallow: /admin', false);

        $sitemap = $this->get('/sitemap.xml')->assertOk();
        $this->assertStringContainsString('xml', $sitemap->headers->get('Content-Type'));
        foreach (['/', '/explore', '/restore', '/carbon', '/journeys/aik-berik-geotour', '/directory/guides'] as $path) {
            $sitemap->assertSee('<loc>'.url($path).'</loc>', false);
        }
        $sitemap->assertDontSee('/admin');
    }

    public function test_pwa_manifest_service_worker_and_icons_exist(): void
    {
        $manifest = json_decode(file_get_contents(public_path('manifest.webmanifest')), true);
        $this->assertSame('standalone', $manifest['display']);
        foreach ($manifest['icons'] as $icon) {
            $this->assertFileExists(public_path(ltrim($icon['src'], '/')));
        }

        $sw = file_get_contents(public_path('sw.js'));
        $this->assertMatchesRegularExpression('/const PRIVATE = (\/.+\/);/', $sw);
        preg_match('/const PRIVATE = \/(.+)\/;/', $sw, $m);
        foreach (['/admin', '/account', '/bookings/ECO-1', '/book/journey/x', '/auth/kuartal-id/callback', '/login'] as $private) {
            $this->assertMatchesRegularExpression('#'.str_replace('\\/', '/', $m[1]).'#', $private, "sw.js must never cache {$private}");
        }

        foreach (['assets/app.css', 'assets/app.js', 'assets/logos/ecoexplore-logo-light.png', 'assets/logos/ecoexplore-logo-dark.png', 'favicon.ico', 'assets/icons/apple-touch-icon.png'] as $file) {
            $this->assertFileExists(public_path($file));
        }
    }

    public function test_every_seeded_image_exists(): void
    {
        foreach ([Journey::pluck('image'), Listing::pluck('image'), RestorationProject::pluck('image')] as $images) {
            foreach ($images->filter() as $image) {
                $this->assertFileExists(public_path($image));
            }
        }
    }
}
