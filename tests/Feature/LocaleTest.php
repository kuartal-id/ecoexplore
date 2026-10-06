<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SampleContentSeeder::class);
    }

    public function test_indonesian_is_the_default(): void
    {
        $this->get('/explore')->assertOk()->assertSee('<html lang="id"', false)->assertSee(__('ui.nav.explore', [], 'id'));
    }

    public function test_english_toggle_switches_the_language_and_returns_to_the_page(): void
    {
        $this->get('/locale/en?redirect=/explore')->assertRedirect('/explore')->assertCookie('locale', 'en', false);

        $this->get('/journeys/rinjani-responsible-trek')->assertOk()
            ->assertSee('<html lang="en"', false)
            ->assertSee('Book this journey');

        $this->get('/locale/id')->assertRedirect();
        $this->get('/explore')->assertSee('<html lang="id"', false);
    }

    public function test_locale_cookie_is_honoured(): void
    {
        $this->withUnencryptedCookie('locale', 'en')->get('/')->assertSee('<html lang="en"', false);
    }

    public function test_unknown_locales_404_and_external_redirects_are_ignored(): void
    {
        $this->get('/locale/fr')->assertNotFound();
        $this->get('/locale/en?redirect=https://evil.example/')->assertRedirect(route('home'));
    }

    public function test_signed_in_user_preference_is_saved(): void
    {
        $user = User::factory()->create(['locale' => 'id']);

        $this->actingAs($user)->get('/locale/en');

        $this->assertSame('en', $user->fresh()->locale);
    }

    public function test_translation_files_have_the_same_keys(): void
    {
        $flatten = function (array $a, string $p = '') use (&$flatten): array {
            $out = [];
            foreach ($a as $k => $v) {
                is_array($v) && ! array_is_list($v) ? $out += $flatten($v, "{$p}{$k}.") : $out["{$p}{$k}"] = true;
            }

            return $out;
        };

        foreach (['ui', 'auth', 'passwords', 'pagination'] as $file) {
            $id = $flatten(require lang_path("id/{$file}.php"));
            $en = $flatten(require lang_path("en/{$file}.php"));
            $this->assertSame([], array_keys(array_diff_key($en, $id)), "lang/id/{$file}.php is missing keys");
            $this->assertSame([], array_keys(array_diff_key($id, $en)), "lang/en/{$file}.php is missing keys");
        }
    }
}
