<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Project;
use App\Models\Testimonial;
use App\Support\SiteCache;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Public website pages. All content is managed in the admin panel. */
class SiteController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'banners' => SiteCache::remember('home.banners', fn () => Banner::active()->get()),
            'featuredProjects' => setting('home_show_featured_projects', '1') === '1'
                ? SiteCache::remember('home.featured', fn () => Project::published()->featured()->ordered()->limit(6)->get())
                : collect(),
            'testimonials' => setting('home_show_testimonials', '1') === '1'
                ? SiteCache::remember('home.testimonials', fn () => Testimonial::active()->with('project')->limit(12)->get())
                : collect(),
            'faqs' => setting('home_show_faqs', '1') === '1'
                ? SiteCache::remember('home.faqs', fn () => Faq::active()->whereIn('category', ['general', 'real_estate'])->limit(8)->get())
                : collect(),
        ]);
    }

    public function development(): View
    {
        return view('development', [
            'projects' => Project::published()->ordered()->limit(6)->get(),
            'faqs' => Faq::active()->where('category', 'real_estate')->get(),
        ]);
    }

    public function projects(Request $request): View
    {
        $status = array_key_exists($request->query('status'), Project::STATUSES) ? $request->query('status') : null;
        $type = array_key_exists($request->query('type'), Project::TYPES) ? $request->query('type') : null;

        return view('projects', [
            'projects' => Project::published()
                ->when($status, fn ($q) => $q->where('status', $status))
                ->when($type, fn ($q) => $q->where('type', $type))
                ->ordered()->paginate(12)->withQueryString(),
            'status' => $status,
            'type' => $type,
            'counts' => Project::published()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function project(string $slug): View
    {
        $project = Project::published()->where('slug', $slug)
            ->with(['gallery', 'floorPlans', 'units', 'testimonials' => fn ($q) => $q->active()])
            ->firstOrFail();

        return view('project', [
            'project' => $project,
            'related' => Project::published()->whereKeyNot($project->id)->ordered()->limit(3)->get(),
        ]);
    }

    public function landowners(): View
    {
        return view('landowners', ['faqs' => Faq::active()->where('category', 'landowner')->get()]);
    }

    public function garmentsServices(): View
    {
        return view('garments-services', ['faqs' => Faq::active()->where('category', 'garments')->get()]);
    }

    public function about(): View
    {
        return $this->renderPage(Page::where('slug', 'about')->where('is_published', true)->firstOrFail());
    }

    public function page(Page $page): View
    {
        abort_if(! $page->is_published || $page->isSystem(), 404);

        return $this->renderPage($page);
    }

    public function contact(): View
    {
        return view('contact', ['page' => Page::where('slug', 'contact')->first()]);
    }

    private function renderPage(Page $page): View
    {
        return view('page', compact('page'));
    }
}
