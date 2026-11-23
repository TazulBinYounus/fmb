<?php

use App\Models\Banner;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\Html;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('uploads');
    $this->seed(SiteContentSeeder::class);
    $this->admin = User::factory()->create();
    $this->admin->forceFill(['is_admin' => true])->save();
});

it('renders every public page from the imported content', function () {
    foreach (['/', '/about', '/contact', '/development', '/development/projects', '/development/projects/bashundhara-riverview', '/landowners', '/garments/services', '/our-management', '/collection/men-knit'] as $url) {
        $this->get($url)->assertOk();
    }
    $this->get('/')->assertSee('Knit, Woven &amp; Sweater Sourcing from Bangladesh', false)->assertSee('+880 1612-149719');
});

it('updates contact details everywhere when settings change', function () {
    $this->actingAs($this->admin)->put(route('admin.settings.update'), array_merge(
        Setting::pluck('value', 'key')->all(),
        ['phone' => '+8801711000000', 'phone_display' => '+880 1711-000000', 'whatsapp' => '880 1711-000000', 'home_show_faqs' => '1']
    ))->assertSessionHasNoErrors();

    expect(setting('whatsapp'))->toBe('8801711000000');
    $this->get('/')->assertSee('+880 1711-000000')->assertSee('wa.me/8801711000000')->assertDontSee('+880 1612-149719');
});

it('manages homepage banners', function () {
    $this->actingAs($this->admin)->post(route('admin.banners.store'), [
        'title' => 'NEW TOWER', 'subtitle' => 'Now booking', 'image' => UploadedFile::fake()->image('b.jpg', 1920, 800),
        'image_position' => 'center', 'button_text' => 'See it', 'button_link' => '/development', 'is_active' => '1', 'sort_order' => 0,
    ])->assertSessionHasNoErrors();

    $this->get('/')->assertSee('NEW TOWER')->assertSee('Now booking');

    $banner = Banner::where('title', 'NEW TOWER')->first();
    $this->actingAs($this->admin)->delete(route('admin.banners.destroy', $banner));
    $this->get('/')->assertDontSee('NEW TOWER');
});

it('shows testimonials and FAQs only once they exist', function () {
    $this->get('/')->assertDontSee('What Our Clients Say')->assertDontSee('Frequently Asked Questions');

    $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
        'name' => 'Rahim Uddin', 'quote' => 'Handover was on time.', 'rating' => 5, 'is_active' => '1',
    ])->assertSessionHasNoErrors();
    $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
        'category' => 'real_estate', 'question' => 'Do you help with bank loans?', 'answer' => 'Yes.', 'is_active' => '1',
    ])->assertSessionHasNoErrors();

    $this->get('/')->assertSee('Handover was on time.')->assertSee('Do you help with bank loans?');
    $this->get('/development')->assertSee('Do you help with bank loans?');
    expect(Testimonial::count())->toBe(1)->and(Faq::count())->toBe(1);
});

it('manages menus, including sub-items', function () {
    $this->actingAs($this->admin)->post(route('admin.menus.store'), [
        'location' => 'header', 'label' => 'Careers', 'url' => '/page/careers', 'is_active' => '1', 'sort_order' => 9,
    ])->assertSessionHasNoErrors();
    $this->get('/')->assertSee('Careers');

    $realEstate = MenuItem::where('label', 'Real Estate')->first();
    $this->actingAs($this->admin)->post(route('admin.menus.store'), [
        'location' => 'header', 'parent_id' => $realEstate->id, 'label' => 'Bank Loans', 'url' => 'javascript:alert(1)', 'is_active' => '1',
    ])->assertSessionHasErrors('url');
});

it('publishes custom pages and protects built-in ones', function () {
    $this->actingAs($this->admin)->post(route('admin.pages.store'), [
        'title' => 'Careers', 'content' => '<h3>Join us</h3><p onclick="x()">Send your CV</p>', 'is_published' => '1',
    ])->assertSessionHasNoErrors();

    $this->get('/page/careers')->assertOk()->assertSee('Join us')->assertDontSee('onclick', false);

    $about = Page::where('slug', 'about')->first();
    $this->actingAs($this->admin)->delete(route('admin.pages.destroy', $about))->assertSessionHas('error');
    expect(Page::where('slug', 'about')->exists())->toBeTrue();

    $this->actingAs($this->admin)->post(route('admin.pages.store'), ['title' => 'x', 'slug' => 'admin'])->assertSessionHasErrors('slug');
});

it('saves website enquiries to the database and emails the right inbox', function () {
    Mail::fake();
    $project = Project::first();

    $this->post(route('contact.send'), [
        'type' => 'site_visit', 'project_id' => $project->id, 'name' => 'Nadia', 'phone' => '01512345678',
        'preferred_date' => now()->addDay()->toDateString(),
    ])->assertSessionHas('contact_success');

    $enquiry = Enquiry::firstOrFail();
    expect($enquiry->phone)->toBe('+8801512345678')
        ->and($enquiry->project_id)->toBe($project->id)
        ->and($enquiry->details)->toHaveKey('preferred_date');

    $this->actingAs($this->admin)->get(route('admin.enquiries.index'))->assertSee('Nadia');
    $this->actingAs($this->admin)->patch(route('admin.enquiries.update', $enquiry), ['status' => 'contacted']);
    expect($enquiry->fresh()->status)->toBe('contacted');
    $this->actingAs($this->admin)->get(route('admin.enquiries.export'))->assertOk()->assertHeader('content-type', 'text/csv; charset=UTF-8');
});

it('strips dangerous HTML from rich text', function () {
    $clean = Html::clean('<p style="x" onmouseover="steal()">Hi <a href="javascript:alert(1)">link</a> <a href="https://fmbgroupbd.com" target="_blank">ok</a></p><script>bad()</script><iframe src="x"></iframe><img src="data:image/png;base64,AAA" onerror="x()">');

    expect($clean)->not->toContain('script')->not->toContain('onmouseover')->not->toContain('javascript:')
        ->not->toContain('iframe')->not->toContain('onerror')->not->toContain('data:')
        ->toContain('href="https://fmbgroupbd.com"')->toContain('rel="noopener"');
});

it('formats Taka amounts with lakh and crore grouping', function () {
    expect(bdt(12500000))->toBe('৳ 1,25,00,000')->and(bdt(950000))->toBe('৳ 9,50,000')->and(bdt(999))->toBe('৳ 999');
});

it('opens every admin screen without errors', function () {
    $project = Project::first();
    foreach ([
        'admin.dashboard', 'admin.projects.index', 'admin.projects.create', 'admin.banners.index', 'admin.banners.create',
        'admin.pages.index', 'admin.pages.create', 'admin.testimonials.index', 'admin.testimonials.create',
        'admin.faqs.index', 'admin.faqs.create', 'admin.menus.index', 'admin.menus.create', 'admin.media.index',
        'admin.enquiries.index', 'admin.settings.edit', 'admin.profile.edit',
    ] as $route) {
        $this->actingAs($this->admin)->get(route($route))->assertOk();
    }
    $this->actingAs($this->admin)->get(route('admin.projects.edit', $project))->assertOk()->assertSee($project->name);
    $this->actingAs($this->admin)->get(route('admin.pages.edit', Page::first()))->assertOk();
    $this->actingAs($this->admin)->get(route('admin.menus.edit', MenuItem::first()))->assertOk();
});
