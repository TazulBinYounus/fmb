<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Support\Html;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    private const FILE_FIELDS = ['cover_image', 'og_image', 'brochure'];

    public function index(Request $request): View
    {
        $trashed = $request->query('view') === 'trash';

        $projects = Project::query()
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', '%'.$request->q.'%')
                ->orWhere('location', 'like', '%'.$request->q.'%')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->withCount(['units', 'gallery'])
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.projects.index', [
            'projects' => $projects,
            'trashed' => $trashed,
            'trashCount' => Project::onlyTrashed()->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project([
            'type' => 'residential', 'status' => 'upcoming', 'is_published' => false,
            'specs' => $this->defaultSpecs(),
        ])]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = DB::transaction(function () use ($request) {
            $project = Project::create($this->payload($request));
            $this->storeGallery($request, $project);

            return $project;
        });

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', "Project \"{$project->name}\" created. Add units, floor plans and more photos below.");
    }

    public function edit(Project $project): View
    {
        $project->load(['gallery', 'floorPlans', 'units']);

        return view('admin.projects.form', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $old = $project->only(self::FILE_FIELDS);
        $project->update($this->payload($request, $project));
        $this->storeGallery($request, $project);

        // Remove replaced/removed files once nothing references them any more.
        foreach ($old as $field => $path) {
            if ($path && $path !== $project->$field) {
                Uploads::delete($path);
            }
        }

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project saved. The website has been updated.');
    }

    /** Quick publish/unpublish and feature/unfeature from the list. */
    public function toggle(Project $project, string $field): RedirectResponse
    {
        abort_unless(in_array($field, ['is_published', 'is_featured'], true), 404);
        $project->update([$field => ! $project->$field]);

        $label = $field === 'is_published'
            ? ($project->is_published ? 'published' : 'unpublished')
            : ($project->is_featured ? 'marked as featured' : 'removed from featured');

        return back()->with('success', "\"{$project->name}\" {$label}.");
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete(); // soft delete – can be restored from Trash

        return redirect()->route('admin.projects.index')->with('success', "\"{$project->name}\" moved to trash. You can restore it from the Trash tab.");
    }

    public function restore(int $id): RedirectResponse
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('admin.projects.index')->with('success', "\"{$project->name}\" restored.");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $project = Project::onlyTrashed()->with(['images', 'units'])->findOrFail($id);
        $name = $project->name;

        DB::transaction(function () use ($project) {
            $files = array_merge(
                array_map(fn ($f) => $project->$f, self::FILE_FIELDS),
                $project->images->pluck('path')->all(),
                $project->units->pluck('floor_plan')->all(),
            );
            $project->forceDelete();               // images/units cascade in the database
            foreach (array_filter($files) as $path) {
                Uploads::delete($path);
            }
        });

        return redirect()->route('admin.projects.index', ['view' => 'trash'])->with('success', "\"{$name}\" permanently deleted.");
    }

    // ---------------------------------------------------------------------

    private function payload(ProjectRequest $request, ?Project $project = null): array
    {
        $data = collect($request->validated())->except([...self::FILE_FIELDS, 'gallery'])->all();

        $data['description'] = Html::clean($data['description'] ?? null);
        $data['description_bn'] = Html::clean($data['description_bn'] ?? null);
        $data['specs'] = collect($data['specs'] ?? [])
            ->filter(fn ($row) => filled($row['label'] ?? null))
            ->map(fn ($row) => [
                'label' => trim($row['label']),
                'label_bn' => trim((string) ($row['label_bn'] ?? '')),
                'value' => trim((string) ($row['value'] ?? '')),
                'value_bn' => trim((string) ($row['value_bn'] ?? '')),
            ])->values()->all();
        $data['amenities'] = collect($data['amenities'] ?? [])
            ->filter(fn ($row) => filled($row['name'] ?? null))
            ->map(fn ($row) => ['name' => trim($row['name']), 'name_bn' => trim((string) ($row['name_bn'] ?? ''))])
            ->values()->all();

        foreach (self::FILE_FIELDS as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = Uploads::store($request->file($field), 'projects');
            } elseif ($project && $request->boolean('remove_'.$field)) {
                $data[$field] = null;
            }
        }

        return $data;
    }

    private function storeGallery(ProjectRequest $request, Project $project): void
    {
        $next = (int) $project->images()->where('type', 'gallery')->max('sort_order');
        foreach ($request->file('gallery', []) as $file) {
            ProjectImage::create([
                'project_id' => $project->id,
                'type' => 'gallery',
                'path' => Uploads::store($file, 'projects'),
                'sort_order' => ++$next,
            ]);
        }
    }

    private function defaultSpecs(): array
    {
        return collect(['RAJUK approval', 'Land area', 'Storeys', 'Facing', 'No. of flats', 'Flat size', 'Bedrooms', 'Car parking', 'Handover'])
            ->map(fn ($label) => ['label' => $label, 'label_bn' => trans($label, [], 'bn') !== $label ? trans($label, [], 'bn') : '', 'value' => '', 'value_bn' => ''])
            ->all();
    }
}
