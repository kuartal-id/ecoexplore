<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'featured' => Journey::published()->orderByDesc('is_featured')->orderBy('sort_order')->take(6)->get(),
            'projects' => RestorationProject::published()->orderBy('sort_order')->take(3)->get(),
            'counts' => [
                'journeys' => Journey::published()->count(),
                'listings' => Listing::published()->count(),
                'projects' => RestorationProject::published()->count(),
                'directories' => count(Listing::TYPES),
            ],
            'listingCounts' => Listing::published()->selectRaw('type, count(*) as n')->groupBy('type')->pluck('n', 'type'),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function terms(): View
    {
        return view('pages.legal', ['page' => 'terms']);
    }

    public function privacy(): View
    {
        return view('pages.legal', ['page' => 'privacy']);
    }

    public function offline(): View
    {
        return view('pages.offline');
    }

    public function robots(): Response
    {
        $body = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /account\nDisallow: /bookings/\nDisallow: /book/\n\nSitemap: ".route('sitemap')."\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(): Response
    {
        $urls = [route('home'), route('explore'), route('restore.index'), route('carbon'), route('about')];

        foreach (Listing::TYPES as $segment) {
            $urls[] = route('directory.index', $segment);
        }
        foreach (Journey::published()->orderBy('sort_order')->pluck('slug') as $slug) {
            $urls[] = route('journeys.show', $slug);
        }
        foreach (RestorationProject::published()->orderBy('sort_order')->pluck('slug') as $slug) {
            $urls[] = route('restore.show', $slug);
        }
        foreach (Listing::published()->orderBy('sort_order')->get(['type', 'slug']) as $listing) {
            $urls[] = route('directory.show', [$listing->segment(), $listing->slug]);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $url) {
            $xml .= '  <url><loc>'.e($url).'</loc></url>'."\n";
        }
        $xml .= '</urlset>'."\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
