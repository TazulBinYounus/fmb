<?php

use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('uploads');
    $this->admin = User::factory()->create();
    $this->admin->forceFill(['is_admin' => true])->save();
    $this->actingAs($this->admin);
});

function projectData(array $overrides = []): array
{
    return array_merge([
        'name' => 'Lake View Residence',
        'type' => 'residential',
        'status' => 'ongoing',
        'location' => 'Uttara, Dhaka',
        'summary' => 'Family apartments near the lake.',
        'description' => '<p>Nice <strong>flats</strong></p><script>alert(1)</script>',
        'price_from' => 9500000,
        'price_to' => 12500000,
        'specs' => [['label' => 'Land area', 'value' => '10 Katha'], ['label' => '', 'value' => 'dropped']],
        'amenities' => [['name' => 'Lift'], ['name' => '']],
        'is_published' => '1',
        'is_featured' => '1',
    ], $overrides);
}

it('creates a project with images, cleaned HTML and a generated slug', function () {
    $this->post(route('admin.projects.store'), projectData([
        'cover_image' => UploadedFile::fake()->image('cover.jpg', 1600, 900),
        'gallery' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.png')],
    ]))->assertRedirect()->assertSessionHas('success');

    $project = Project::where('slug', 'lake-view-residence')->firstOrFail();
    expect($project->description)->toBe('<p>Nice <strong>flats</strong></p>')
        ->and($project->specs)->toHaveCount(1)
        ->and($project->amenities)->toBe([['name' => 'Lift', 'name_bn' => '']])
        ->and($project->gallery)->toHaveCount(2);

    Storage::disk('uploads')->assertExists($project->cover_image);
    expect(ActivityLog::where('subject_id', $project->id)->where('action', 'created')->exists())->toBeTrue();
});

it('validates project input', function () {
    $this->post(route('admin.projects.store'), projectData([
        'name' => '', 'status' => 'bogus', 'price_from' => 100, 'price_to' => 50,
        'video_url' => 'https://vimeo.com/123', 'cover_image' => UploadedFile::fake()->create('x.exe', 10),
    ]))->assertSessionHasErrors(['name', 'status', 'price_to', 'video_url', 'cover_image']);

    expect(Project::count())->toBe(0);
});

it('shows published projects on the website and hides unpublished ones', function () {
    $this->post(route('admin.projects.store'), projectData());
    $project = Project::firstOrFail();

    $this->get(route('project.show', $project->slug))->assertOk()->assertSee('Lake View Residence')->assertSee('10 Katha')->assertSee('৳ 95,00,000');
    $this->get('/')->assertSee('Lake View Residence');            // featured on homepage
    $this->get(route('projects.index'))->assertSee('Lake View Residence');

    $this->patch(route('admin.projects.toggle', [$project, 'is_published']))->assertRedirect();
    expect($project->fresh()->is_published)->toBeFalse();
    $this->get(route('project.show', $project->slug))->assertNotFound();
    $this->get('/')->assertDontSee('Lake View Residence');
});

it('updates a project and replaces its cover image', function () {
    $this->post(route('admin.projects.store'), projectData(['cover_image' => UploadedFile::fake()->image('old.jpg')]));
    $project = Project::firstOrFail();
    $oldCover = $project->cover_image;

    $this->put(route('admin.projects.update', $project), projectData([
        'name' => 'Lake View Residence Phase 2', 'slug' => 'lake-view-2', 'status' => 'sold_out',
        'cover_image' => UploadedFile::fake()->image('new.jpg'),
    ]))->assertRedirect(route('admin.projects.edit', 'lake-view-2'));

    $project->refresh();
    expect($project->status)->toBe('sold_out')->and($project->cover_image)->not->toBe($oldCover);
    Storage::disk('uploads')->assertMissing($oldCover);
    Storage::disk('uploads')->assertExists($project->cover_image);
});

it('keeps an image file that is still used as the cover when its gallery entry is deleted', function () {
    $this->post(route('admin.projects.store'), projectData(['gallery' => [UploadedFile::fake()->image('a.jpg')]]));
    $project = Project::firstOrFail();
    $image = $project->gallery->first();

    $this->patch(route('admin.projects.images.cover', [$project, $image]));
    $this->delete(route('admin.projects.images.destroy', [$project, $image]));

    expect(ProjectImage::count())->toBe(0);
    Storage::disk('uploads')->assertExists($image->path);   // still the cover image
});

it('manages unit types', function () {
    $this->post(route('admin.projects.store'), projectData());
    $project = Project::firstOrFail();

    $this->post(route('admin.projects.units.store', $project), [
        'name' => 'Type A', 'bedrooms' => 3, 'bathrooms' => 3, 'size_sqft' => 1450, 'price' => 10500000, 'availability' => 'available',
        'floor_plan' => UploadedFile::fake()->image('plan.png'),
    ])->assertSessionHasNoErrors();
    $unit = $project->units()->firstOrFail();

    $this->get(route('project.show', $project->slug))->assertSee('Type A')->assertSee('1,450');

    $this->put(route('admin.projects.units.update', [$project, $unit]), ['name' => 'Type A', 'availability' => 'sold'])->assertSessionHasNoErrors();
    expect($unit->fresh()->availability)->toBe('sold');

    $this->delete(route('admin.projects.units.destroy', [$project, $unit]));
    expect($project->units()->count())->toBe(0);
    Storage::disk('uploads')->assertMissing($unit->floor_plan);
});

it('moves deleted projects to trash, restores them and deletes them forever', function () {
    $this->post(route('admin.projects.store'), projectData(['cover_image' => UploadedFile::fake()->image('c.jpg')]));
    $project = Project::firstOrFail();

    $this->delete(route('admin.projects.destroy', $project));
    expect(Project::count())->toBe(0)->and(Project::onlyTrashed()->count())->toBe(1);
    $this->get(route('project.show', $project->slug))->assertNotFound();

    $this->post(route('admin.projects.restore', $project->id));
    expect(Project::count())->toBe(1);

    $this->delete(route('admin.projects.destroy', $project));
    $this->delete(route('admin.projects.force-delete', $project->id));
    expect(Project::withTrashed()->count())->toBe(0);
    Storage::disk('uploads')->assertMissing($project->cover_image);
});

it('shows Bangla project content when the site is in Bangla', function () {
    $this->post(route('admin.projects.store'), projectData(['name_bn' => 'লেক ভিউ রেসিডেন্স']));
    $project = Project::firstOrFail();

    $this->withSession(['locale' => 'bn'])->get(route('project.show', $project->slug))->assertSee('লেক ভিউ রেসিডেন্স');
});
