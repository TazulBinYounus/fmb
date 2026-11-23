<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectUnit;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/** Gallery photos, floor plans and unit types of a project. */
class ProjectMediaController extends Controller
{
    // Images ----------------------------------------------------------------

    public function storeImages(Request $request, Project $project): RedirectResponse
    {
        $request->validate([
            'type' => ['required', Rule::in(['gallery', 'floor_plan'])],
            'images' => ['required', 'array', 'max:30'],
            'images.*' => Uploads::IMAGE_RULES,
        ], ['images.required' => 'Choose at least one image to upload.']);

        $next = (int) $project->images()->where('type', $request->type)->max('sort_order');
        foreach ($request->file('images') as $file) {
            ProjectImage::create([
                'project_id' => $project->id,
                'type' => $request->type,
                'path' => Uploads::store($file, 'projects'),
                'sort_order' => ++$next,
            ]);
        }

        $count = count($request->file('images'));
        $what = $request->type === 'gallery' ? 'gallery photo' : 'floor plan';

        return $this->back($project, 'media', "{$count} {$what}".($count > 1 ? 's' : '').' uploaded.');
    }

    /** Saves captions and order for all images of the project in one go. */
    public function updateImages(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'images' => ['required', 'array'],
            'images.*.caption' => ['nullable', 'string', 'max:255'],
            'images.*.caption_bn' => ['nullable', 'string', 'max:255'],
            'images.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        DB::transaction(function () use ($data, $project) {
            foreach ($data['images'] as $id => $values) {
                $project->images()->whereKey($id)->first()?->update([
                    'caption' => $values['caption'] ?? null,
                    'caption_bn' => $values['caption_bn'] ?? null,
                    'sort_order' => (int) ($values['sort_order'] ?? 0),
                ]);
            }
        });

        return $this->back($project, 'media', 'Captions and order saved.');
    }

    public function destroyImage(Project $project, ProjectImage $image): RedirectResponse
    {
        abort_unless($image->project_id === $project->id, 404);
        $path = $image->path;
        $image->delete();
        Uploads::delete($path);

        return $this->back($project, 'media', 'Image deleted.');
    }

    public function useAsCover(Project $project, ProjectImage $image): RedirectResponse
    {
        abort_unless($image->project_id === $project->id, 404);
        $project->update(['cover_image' => $image->path]);

        return $this->back($project, 'media', 'Cover image updated.');
    }

    // Units -----------------------------------------------------------------

    public function storeUnit(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateUnit($request);
        if ($request->hasFile('floor_plan')) {
            $data['floor_plan'] = Uploads::store($request->file('floor_plan'), 'projects');
        }
        $project->units()->create($data);

        return $this->back($project, 'units', "Unit \"{$data['name']}\" added.");
    }

    public function updateUnit(Request $request, Project $project, ProjectUnit $unit): RedirectResponse
    {
        abort_unless($unit->project_id === $project->id, 404);
        $data = $this->validateUnit($request);

        $oldPlan = $unit->floor_plan;
        if ($request->hasFile('floor_plan')) {
            $data['floor_plan'] = Uploads::store($request->file('floor_plan'), 'projects');
        } elseif ($request->boolean('remove_floor_plan')) {
            $data['floor_plan'] = null;
        }
        $unit->update($data);
        if ($oldPlan && $oldPlan !== $unit->floor_plan) {
            Uploads::delete($oldPlan);
        }

        return $this->back($project, 'units', "Unit \"{$unit->name}\" saved.");
    }

    public function destroyUnit(Project $project, ProjectUnit $unit): RedirectResponse
    {
        abort_unless($unit->project_id === $project->id, 404);
        $path = $unit->floor_plan;
        $unit->delete();
        Uploads::delete($path);

        return $this->back($project, 'units', 'Unit deleted.');
    }

    private function validateUnit(Request $request): array
    {
        return collect($request->validate([
            'name' => ['required', 'string', 'max:100'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:20'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:20'],
            'balconies' => ['nullable', 'integer', 'min:0', 'max:20'],
            'size_sqft' => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999999999'],
            'availability' => ['required', Rule::in(array_keys(ProjectUnit::AVAILABILITY))],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'floor_plan' => ['nullable', ...Uploads::IMAGE_RULES],
        ]))->except('floor_plan')->map(fn ($v, $k) => $k === 'sort_order' ? (int) $v : $v)->all();
    }

    private function back(Project $project, string $section, string $message): RedirectResponse
    {
        return redirect()->to(route('admin.projects.edit', $project).'#'.$section)->with('success', $message);
    }
}
